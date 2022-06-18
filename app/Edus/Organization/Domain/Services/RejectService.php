<?php

namespace App\Edus\Organization\Domain\Services;

use App\Edus\Organization\Domain\Repositories\OrganizationRepository as Repository;
use App\Exceptions\MainException;
use App\Domain\Payloads\SuccessPayload;
use App\Edus\AccessStatus\Domain\Models\AccessStatus;

class RejectService
{

    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $organization_id ID место 
     * @param array<mixed> $body Данные с запроса
     * 
     * @throws MainException
     * 
     * @return SuccessPayload
     */
    public function handle($organization_id = 0, $body = array())
    {
        $admin = auth()->user();
        $where = array(
            "id" => $organization_id, 
            "access_status_id" => AccessStatus::UNDER_REVIEW
        );

        if(isset($admin->punkt_id))
        {
            $where["punkt_id"] = $admin->punkt_id;
        }
        if(isset($admin->is_test))
        {
            $where["is_test"] = $admin->is_test;
        }

        $data["access_status_id"] = AccessStatus::NOT_ADMITTED;
        // Меняем статус с На проверке на Не допущен!
        if($this->repository->updateWhere($where, $data) > 0) 
        {
            $comment = $body["comment"]; //TODO: add to log
            return new SuccessPayload(__("Success updated"));
        }
        throw new MainException("Not updated");        
    }

}