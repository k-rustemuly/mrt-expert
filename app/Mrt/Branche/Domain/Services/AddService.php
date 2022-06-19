<?php

namespace App\Mrt\Branche\Domain\Services;

use App\Mrt\Branche\Domain\Repositories\BrancheRepository as Repository;
use App\Domain\Payloads\SuccessPayload;
use App\Exceptions\MainException;

class AddService
{
    public $name = "branche";

    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($data = [])
    {
        $branche = $this->repository->create($data);
        if($branche != null)
            return new SuccessPayload("New branche success added");

        throw new MainException("Error to add");
    }

}