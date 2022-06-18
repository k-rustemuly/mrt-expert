<?php

namespace App\Edus\Upload\Domain\Services;

use App\Edus\Upload\Domain\Repositories\UploadRepository as Repository;
use App\Domain\Payloads\SuccessPayload;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\MainException;


class DeleteService
{

    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($id = 0, $uuid = "unknown")
    {
        $upload = $this->repository->getById($id);
        if($upload->uuid != $uuid) 
        {
            throw new MainException("Permission denied");
        }
        if(!Storage::delete($upload->file_path))
        {
            throw new MainException("File not deleted");
        }
        $this->repository->delete($id);
        return new SuccessPayload(__("File success deleted"));
    }
}