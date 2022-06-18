<?php

namespace App\Edus\Organization\Domain\Services;

use App\Domain\Payloads\GenericPayload;
use App\Domain\Services\Service;
use App\Edus\Pki\Api;
use App\Edus\Stat\Api as StatApi;
use App\Edus\Organization\Domain\Repositories\OrganizationRepository as Repository;
use App\Edus\Punkt\Domain\Repositories\PunktRepository;
use App\Edus\OrganizationAdmin\Domain\Repositories\AdminRepository as AdminRepository;
use App\Exceptions\MainException;
use App\Edus\Pki\CertificateInfo;

class EcpAuthService extends Service
{
    protected $api;

    protected $statApi;

    protected $repository;

    protected $punktRepository;

    protected $adminRepository;

    public function __construct(Api $api, StatApi $statApi, Repository $repository, PunktRepository $punktRepository, AdminRepository $adminRepository)
    {
        $this->api = $api;
        $this->statApi = $statApi;
        $this->repository = $repository;
        $this->punktRepository = $punktRepository;
        $this->adminRepository = $adminRepository;
    }

    public function handle($data = [])
    {
        $p12 = $data["p12"];
        $password = $data["password"];

        $certInfo = $this->api->pkcs($p12, $password);
        $this->firstflyCheckCert($certInfo);
        $bin = $certInfo->isIndividual() ? $certInfo->getIin(): $certInfo->getBin();

        $organization = $this->repository->getByBin($bin);

        if(!$organization)
        {
            //Если в базе не нашли организацию, то начинаем регистрировать
            $this->mainCheckCert($certInfo);
            $organizationInfo = $this->statApi->info($bin);
            $kato = $organizationInfo->katoCode;
            if($kato != null && strlen($kato) == 9) 
            {
                $abbreviation = substr($kato, 0, 4);
                $searchedKato = $abbreviation . "00000";
                $punktInfo = $this->punktRepository->getByKato($searchedKato);
                if(!$punktInfo)
                {
                    throw new MainException("By you kato code not found deparment");
                }
                $punkt_id = $punktInfo->id;
            }
            $insert = [
                "bin" => $bin,
                "oked_code" => $organizationInfo->okedCode,
                "krp_code" => $organizationInfo->krpCode,
                "kato_code" => $kato,
                "director_fullname" => $organizationInfo->fio,
                "is_ip" => $organizationInfo->ip,
                "punkt_id" => $punkt_id
            ];
            $organization = $this->repository->create($insert)->fresh();
        }
        if(!$organization["is_test"]) $this->mainCheckCert($certInfo);
        if(!$organization["is_access"]) throw new MainException("The access is denied");
        $admin = $this->adminRepository->getByIdAndIin($organization->id, $certInfo->getIin());
        if(!$admin)
        {
            //Если в базе не нашли админа организации, то начинаем регистрировать админа
            $this->adminRepository->create([
                "organization_id" => $organization->id,
                "bin" => $bin,
                "iin" => $certInfo->getIin(),
                "full_name" => $certInfo->getFullName(),
            ])->fresh();
            $admin = $this->adminRepository->getByIdAndIin($organization->id, $certInfo->getIin());
        }

        auth('organization')->login($admin);
        $admin->update(["last_visit" => now()]);
        return new GenericPayload(
            array(
                "user" => [
                    "name" => $admin->full_name,
                    "organization_id" => $organization["id"],
                    "organization_name" => [
                        "ru" => $organization["name_ru"],
                        "kk" => $organization["name_kk"]
                    ]
                ],
                "token" => $admin->generateAuthToken(["punkt_id" => $organization["punkt_id"]])
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
        if($certInfo->isLegalEntity())
        {
            if(!$certInfo->isCeo() && !$certInfo->isCanSign())
            {
                throw new MainException("Certificate error for legal entity");
            }
        }
    }
}