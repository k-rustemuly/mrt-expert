<?php

namespace App\Edus\Organization\Domain\Services;

use App\Edus\EducationOrganizationFile\Domain\Repositories\EducationOrganizationFileRepository as Repository;
use App\Edus\Upload\Domain\Repositories\UploadRepository;
use App\Edus\Organization\Domain\Repositories\OrganizationRepository;
use App\Edus\AccessStatus\Domain\Models\AccessStatus;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\MainException;

class DeleteFileService
{

    protected $repository;

    protected $uploadRepository;

    protected $organizationRepository;

    public function __construct(Repository $repository, UploadRepository $uploadRepository, OrganizationRepository $organizationRepository)
    {
        $this->repository = $repository;
        $this->uploadRepository = $uploadRepository;
        $this->organizationRepository = $organizationRepository;
    }

    public function handle($file_id = 0)
    {
        $user = auth('organization')->user();
        $organization_id = $user->organization_id;
        $fileInfo = $this->repository->getInfoFile($organization_id, $file_id);
        if($fileInfo == null)
        {
            throw new MainException("File not found");
        }
        if(!Storage::delete($fileInfo->file_path))
        {
            throw new MainException("File not deleted");
        }
        $this->repository->delete($file_id);
        $this->uploadRepository->delete($fileInfo->upload_id);
        $this->organizationRepository->updateWhere(["id" => $organization_id], ["access_status_id" => AccessStatus::FILLED_IN]);
    }
}