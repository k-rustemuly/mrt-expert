<?php

namespace App\Mrt\Upload\Domain\Services;

use App\Mrt\Upload\Domain\Repositories\UploadRepository as Repository;
use App\Domain\Payloads\GenericPayload;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\MainException;

class LocalService
{

    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($file = null, $files = array())
    {
        $name = $file->getClientOriginalName();
        $unique_name = Str::orderedUuid(); // Generate a unique, random name...
        $extension = "*"; // Determine the file's extension based on the file's MIME type...
        $filepath = $this->generatePath();
        Storage::put('avatars/1', $file);
        // $config = Config::get('filesystems.disks.s3');
        // if(File::streamUpload($filepath, $unique_name, $file, false))
        // {
        //     $path = $filepath."/".$unique_name;
        //     $url = $config['url'].$path;
        //     $uuid = Str::orderedUuid();
        //     $upload_id = $this->repository->create([
        //             "uuid" => $uuid,
        //             "name" => $name,
        //             "path" => $path,
        //             "url" => $url,
        //             "extension" => $extension
        //         ])["id"];
        //     return new GenericPayload(["id" => $upload_id, "uuid" => $uuid]);
        // }
        throw new MainException("Error to upload file");
    }

    private function generatePath():string
    {
        return  "uploads/".date("Y/m/d");
    }
}