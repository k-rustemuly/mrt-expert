<?php

namespace App\Edus\Organization\Domain\Services;

use App\Domain\Payloads\SuccessPayload;
use App\Domain\Services\Service;
use App\Edus\Organization\Domain\Repositories\OrganizationRepository as Repository;
use App\Exceptions\MainException;
use App\Edus\AccessStatus\Domain\Models\AccessStatus;

class SaveService extends Service
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
        if(isset($data["direction"]) && is_array($data["direction"]))
        {
            $data["direction"] = "@".implode("@", $data["direction"])."@";
        }
        if($this->repository->updateWhere($where, $data) > 0) 
        {
            return new SuccessPayload(__("Success updated"));
        }
        throw new MainException("Not updated");        
    }

}