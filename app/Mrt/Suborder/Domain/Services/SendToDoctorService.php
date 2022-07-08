<?php

namespace App\Mrt\Suborder\Domain\Services;

use App\Mrt\Suborder\Domain\Repositories\SuborderRepository as Repository;
use App\Domain\Payloads\SuccessPayload;
use App\Exceptions\MainException;
use App\Mrt\Upload\Domain\Repositories\UploadRepository;

class SendToDoctorService
{

    protected $repository;

    protected $uploadRepository;

    public function __construct(Repository $repository, UploadRepository $uploadRepository)
    {
        $this->repository = $repository;
        $this->uploadRepository = $uploadRepository;
    }

    public function handle($suborder_id = 0, $data = [])
    {
        $user = auth('assistant')->user();
        $branch_id = $user->branch_id;
        $data["doctors"] = "@".implode('@', $data["doctors"])."@";
        $data["file"] = $this->uploadRepository->getIdByUuid($data["file"]);
        $suborder = $this->repository->updateByBranchId($branch_id, $suborder_id, $data);
        if($suborder != null)
            return new SuccessPayload(__("Suborder success updated"));

        throw new MainException("Error to update suborder");
    }

}