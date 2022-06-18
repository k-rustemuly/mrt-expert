<?php

namespace App\Edus\Place\Domain\Services;

use App\Domain\Payloads\SuccessPayload;
use App\Domain\Services\Service;
use App\Edus\Place\Domain\Repositories\PlaceRepository as Repository;
use App\Exceptions\MainException;
use App\Edus\PlaceStatus\Domain\Models\PlaceStatus;

class PublishService extends Service
{
    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 
     * @param string|int $place_id ID место 
     */
    public function handle($place_id = 0)
    {
        $admin = auth()->user();
        $where = array(
            "id" => $place_id, 
            "place_status_id" => PlaceStatus::DRAFT
        );

        if(isset($admin->punkt_id))
        {
            $where["punkt_id"] = $admin->punkt_id;
        }
        if(isset($admin->is_test))
        {
            $where["is_test"] = $admin->is_test;
        }

        $data["place_status_id"] = PlaceStatus::PUBLISHED;
        // Меняем статус с черновика на опубликовано!
        if($this->repository->updateWhere($where, $data) > 0) 
        {
            return new SuccessPayload(__("Success updated"));
        }
        throw new MainException("Not updated");        
    }

}