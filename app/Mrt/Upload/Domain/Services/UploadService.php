<?php

namespace App\Mrt\Upload\Domain\Services;

use App\Mrt\Upload\Domain\Repositories\UploadRepository as Repository;
use App\Domain\Payloads\GenericPayload;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

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
        $filepath = $this->generatePath();

        File::streamUpload($filepath, $name, $file, false);
        // $path = Storage::putFileAs($this->generatePath(), $file, $unique_name);
        // $url = Storage::url($path);
        // $size = Storage::size($path);
        $uuid = Str::orderedUuid();
        // $upload_id = $this->repository->create([
        //     "uuid" => $uuid,
        //     "file_path" => $path,
        //     "file_url" => $url,
        //     "file_size" => $size,
        //     "file_extension" => $extension
        // ])["id"];
        $upload_id = 0;
        return new GenericPayload(["id" => $upload_id, "uuid" => $uuid]);
    }

    private function generatePath():string
    {
        return  "uploads/".date("Y/m/d");
    }
}