<?php

namespace App\Mrt\Assistant\Domain\Services;

use App\Mrt\Assistant\Domain\Repositories\AssistantRepository as Repository;
use App\Domain\Payloads\SuccessPayload;
use App\Exceptions\MainException;

class SaveService
{

    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($assistant_id = 0, $data = [])
    {
        $user = auth('branche_admin')->userOrFail();
        $Assistant = $this->repository->getById($assistant_id);
        if($Assistant->branche_id != $user->branche_id)
        {
            throw new MainException("Error to save assistant");
        }

        $Assistant = $this->repository->updateById($assistant_id, $data);
        if($Assistant != null)
            return new SuccessPayload(__("Assistant success saved"));

        throw new MainException("Error to save Assistant");
    }

}