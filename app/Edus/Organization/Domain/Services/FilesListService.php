<?php

namespace App\Edus\Organization\Domain\Services;

use App\Edus\Organization\Domain\Repositories\OrganizationRepository as Repository;
use App\Domain\Payloads\GenericPayload;
use App\Edus\EducationOrganizationFile\Domain\Repositories\EducationOrganizationFileRepository;

class FilesListService
{

    protected $repository;

    protected $fileRepository;

    public function __construct(Repository $repository, EducationOrganizationFileRepository $fileRepository)
    {
        $this->repository = $repository;
        $this->fileRepository = $fileRepository;
    }

    /**
     * @param string $organization_id ID место 
     * @param string $file_type_id ID тип файла 
     */
    public function handle($organization_id = 0, $file_type_id = 0)
    {
        $files = $this->fileRepository->getList($organization_id, $file_type_id);
        return new GenericPayload($files);
    }

}