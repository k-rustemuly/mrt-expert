<?php

namespace App\Edus\Departments\Domain\Services;

use App\Domain\Payloads\GenericPayload;
use App\Domain\Services\Service;
use App\Edus\Pki\Api;
use App\Edus\Departments\Domain\Repositories\DepartmentRepository as Repository;
use App\Exceptions\MainException;
use App\Edus\Organization\Domain\Repositories\OrganizationRepository;
use App\Edus\Pki\CertificateInfo;

class EcpAuthService extends Service
{
    protected $api;

    protected $repository;

    protected $organizationRepository;

    public function __construct(Api $api, Repository $repository, OrganizationRepository $organizationRepository)
    {
        $this->api = $api;
        $this->repository = $repository;
        $this->organizationRepository = $organizationRepository;
    }

    public function handle($data = [])
    {
        $p12 = $data["p12"];
        $password = $data["password"];

        $certInfo = $this->api->pkcs($p12, $password);
        $this->firstflyCheckCert($certInfo);

        $user = $this->repository->getByBinAndIin($certInfo->getBin(), $certInfo->getIin());

        if(!$user) throw new MainException("The education department employee not registered");
        if(!$user->is_test) $this->mainCheckCert($certInfo);
        if(!$user->is_access) throw new MainException("The access is denied");

        $organization = $this->organizationRepository->getByBin($certInfo->getBin());
        auth('department')->login($user);
        $user->update(["last_visit" => now()]);
        return new GenericPayload(
            array(
                "user" => [
                    "name" => $user->full_name,
                    "organization_name" => [
                        "ru" => $organization->name_ru,
                        "kk" => $organization->name_kk
                    ]
                ],
                "token" => $user->generateAuthToken()
            )
        );
    }

    /**
     * Первичные проверки сертификата
     * 
     * @param CertificateInfo $certInfo
     * 
     * @throws MainException
     */
    protected function firstflyCheckCert(CertificateInfo $certInfo)
    {
        if(!$certInfo->isAuth()) 
        {
            throw new MainException("The certificate is must be AUTH type");
        }

        if(!$certInfo->isLegalEntity())
        {
            throw new MainException("The certificate is must be for organization");
        }

        if(!$certInfo->isCeo() && !$certInfo->isCanSign())
        {
            throw new MainException("The certificate is must be one of the following: is Ceo, can sign");
        }
    }

    /**
     * Основные проверки сертификата
     * 
     * @param CertificateInfo $certInfo
     * 
     * @throws MainException
     */
    protected function mainCheckCert(CertificateInfo $certInfo)
    {
        if($certInfo->isExpired()) 
        {
            throw new MainException("The certificate is expired");
        }

        if(!$certInfo->isLegal())
        {
            throw new MainException("The certificate is not legal");
        }
    }
}