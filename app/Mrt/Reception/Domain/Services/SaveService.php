<?php

namespace App\Mrt\Reception\Domain\Services;

use App\Mrt\Reception\Domain\Repositories\ReceptionRepository as Repository;
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

    public function handle($reception_id = 0, $data = [])
    {
        $user = auth('branch_admin')->user();
        $reception = $this->repository->getById($reception_id);
        if($reception->branch_id != $user->branch_id)
        {
            throw new MainException("Error to save Reception");
        }
        if(isset($data["password"]))
        {
            $data["password"] = Hash::make($data["password"]);
        }
        $reception = $this->repository->updateById($reception_id, $data);
        if($reception != null)
            return new SuccessPayload(__("Reception success saved"));

        throw new MainException("Error to save Reception");
    }

}