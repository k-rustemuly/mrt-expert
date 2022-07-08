<?php

namespace App\Mrt\Doctor\Domain\Services;

use App\Mrt\Doctor\Domain\Repositories\DoctorRepository as Repository;
use App\Mrt\Suborder\Domain\Repositories\SuborderRepository;
use App\Domain\Payloads\GenericPayload;

class ListForSuborderService 
{
    protected $repository;

    protected $suborderRepository;

    public function __construct(Repository $repository, SuborderRepository $suborderRepository)
    {
        $this->repository = $repository;
        $this->suborderRepository = $suborderRepository;
    }

    public function handle($suborder_id = 0)
    {
        $aboutSuborder = $this->suborderRepository->getById($suborder_id);
        $subservice_id = $aboutSuborder["subservice_id"];
        $datas = $this->repository->getAllBySubserviceId($subservice_id);
        $doctors = array();
        for($i=0; $i<count($datas); $i++)
        {
            $doctors[] = [
                "id" => $datas[$i]["id"],
                "name" => $datas[$i]["full_name"],
                "children" => []
            ];
        }
        return new GenericPayload($doctors);
    }

}