<?php

namespace App\Edus\Organization\Domain\Services;

use App\Edus\EducationOrganizationFile\Domain\Repositories\EducationOrganizationFileRepository as Repository;
use App\Edus\Upload\Domain\Repositories\UploadRepository as UploadRepository;
use App\Domain\Payloads\SuccessPayload;
use Illuminate\Support\Facades\Storage;


class AddFileService
{

    protected $repository;

    protected $uploadRepository;

    public $organization_id;

    public function __construct(Repository $repository, UploadRepository $uploadRepository)
    {
        $this->repository = $repository;
        $this->uploadRepository = $uploadRepository;
    }

    public function handle($file_type_id = 0, $file = null)
    {
        $user = auth('organization')->user();
        $this->organization_id = $user->organization_id;
        $name = $file->getClientOriginalName();
        $unique_name = $file->hashName(); // Generate a unique, random name...
        $extension = $file->extension(); // Determine the file's extension based on the file's MIME type...
        $path = Storage::putFileAs($this->generatePath(), $file, $unique_name);
        $url = Storage::url($path);
        $size = Storage::size($path);
        $upload_id = $this->uploadRepository->create([
            "file_path" => $path,
            "file_url" => $url,
            "file_size" => $size,
            "file_extension" => $extension
        ])["id"];
        $order = $this->repository->getNextOrder($this->organization_id, $file_type_id);
        $myFile = $this->repository->create(
            [
                "organization_id" => $this->organization_id,
                "file_type_id" => $file_type_id,
                "file_name" => $name,
                "file_order" => $order,
                "upload_id" => $upload_id
            ]
        );
        return new SuccessPayload(__("File success uploaded"), ["id" => $myFile->id]);
    }

    private function generatePath():string
    {
        return  "uploads/".date("Y/m/d");
    }
}