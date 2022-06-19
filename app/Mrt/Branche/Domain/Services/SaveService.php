<?php

namespace App\Mrt\Branche\Domain\Services;

use App\Mrt\Branche\Domain\Repositories\BrancheRepository as Repository;
use App\Domain\Payloads\SuccessPayload;
use App\Exceptions\MainException;

class SaveService
{
    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($branche_id = 0 , $data = [])
    {
        $branche = $this->repository->updateById($branche_id, $data);
        if($branche != null)
            return new SuccessPayload(__("Branche success saved"));

        throw new MainException("Error saving");
    }

}