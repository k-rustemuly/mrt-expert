<?php

namespace App\Edus\Upload\Domain\Services;

use App\Edus\Upload\Domain\Repositories\UploadRepository as Repository;
use App\Domain\Payloads\GenericPayload;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;



class UploadService
{

    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($file = null, $files = array())
    {
        $name = $file->getClientOriginalName();
        $unique_name = $file->hashName(); // Generate a unique, random name...
        $extension = $file->extension(); // Determine the file's extension based on the file's MIME type...
        $path = Storage::putFileAs($this->generatePath(), $file, $unique_name);
        $url = Storage::url($path);
        $size = Storage::size($path);
        $uuid = Str::orderedUuid();
        $upload_id = $this->repository->create([
            "uuid" => $uuid,
            "file_path" => $path,
            "file_url" => $url,
            "file_size" => $size,
            "file_extension" => $extension
        ])["id"];
        
        return new GenericPayload(["id" => $upload_id, "uuid" => $uuid]);
    }

    private function generatePath():string
    {
        return  "uploads/".date("Y/m/d");
    }
}