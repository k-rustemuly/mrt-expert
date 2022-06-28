<?php

namespace App\Mrt\Assistant\Domain\Services;

use App\Mrt\Assistant\Domain\Repositories\AssistantRepository as Repository;
use App\Domain\Payloads\SuccessPayload;
use App\Exceptions\MainException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AddService
{

    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($data = [])
    {
        $user = auth('branch_admin')->user();
        $data["branch_id"] = $user->branch_id;
        $data["password"] = Hash::make($data["password"]);
        $assistant = $this->repository->create($data);
        if($assistant != null)
            return new SuccessPayload(__("New assistant success added"));

        throw new MainException("Error to add new assistant");
    }

}