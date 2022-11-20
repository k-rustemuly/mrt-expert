<?php

namespace App\Mrt\Upload\Domain\Services;

use App\Mrt\Upload\Domain\Repositories\UploadRepository as Repository;
use App\Domain\Payloads\GenericPayload;
use Illuminate\Support\Str;

class AwsUploadService
{

    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($data = array())
    {
        $name = $data["name"];
        $extension = $data["extension"];
        $path = $data["path"];
        $uuid = $data["uuid"];
        $url = config("filesystems.disks.s3.url").$path;
        $uuid = Str::orderedUuid();
        $upload_id = $this->repository->create([
                "uuid" => $uuid,
                "name" => $name,
                "path" => $path,
                "url" => $url,
                "extension" => $extension
            ])["id"];
        return new GenericPayload(["id" => $upload_id, "uuid" => $uuid]);
    }
}
