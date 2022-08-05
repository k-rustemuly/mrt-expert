<?php

namespace App\Mrt\Assistant\Domain\Services;

use App\Mrt\Assistant\Domain\Repositories\AssistantRepository as Repository;
use App\Domain\Payloads\SuccessPayload;
use App\Exceptions\MainException;
use Illuminate\Support\Facades\Hash;

class SaveService
{

    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($assistant_id = 0, $data = [])
    {
        $user = auth('branch_admin')->user();
        $Assistant = $this->repository->getById($assistant_id);
        if($Assistant->branch_id != $user->branch_id)
        {
            throw new MainException("Error to save assistant");
        }
        if(isset($data["password"]))
        {
            $data["password"] = Hash::make($data["password"]);
        }

        $Assistant = $this->repository->updateById($assistant_id, $data);
        if($Assistant != null)
            return new SuccessPayload(__("Assistant success saved"));

        throw new MainException("Error to save Assistant");
    }

}