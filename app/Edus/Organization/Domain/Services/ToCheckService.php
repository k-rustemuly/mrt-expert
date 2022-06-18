<?php

namespace App\Edus\Organization\Domain\Services;

use App\Domain\Payloads\SuccessPayload;
use App\Domain\Services\Service;
use App\Edus\Organization\Domain\Repositories\OrganizationRepository as Repository;
use App\Exceptions\MainException;
use App\Edus\AccessStatus\Domain\Models\AccessStatus;

class ToCheckService extends Service
{
    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 
     * @param array<mixed> $data
     */
    public function handle($data = [])
    {
        $user = auth('organization')->user();
        $organization_id = $user->organization_id;
        $where = array(
            "id" => $organization_id, 
            "access_status_id" => AccessStatus::FILLED_IN
        );
        $update = array("access_status_id" => AccessStatus::UNDER_REVIEW);
        if($this->repository->updateWhere($where, $update) > 0) 
        {
            return new SuccessPayload(__("Success updated"));
        }
        throw new MainException("Not updated");        
    }

}