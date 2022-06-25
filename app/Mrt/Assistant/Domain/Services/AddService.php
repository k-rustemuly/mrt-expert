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
        $user = auth('branch_admin')->userOrFail();
        $data["branch_id"] = $user->branch_id;
        $password = Str::random(8);
        $data["password"] = Hash::make($password);
        $assistant = $this->repository->create($data);
        if($assistant != null)
            return new SuccessPayload(__("New assistant success added"));

        throw new MainException("Error to add new assistant");
    }

}