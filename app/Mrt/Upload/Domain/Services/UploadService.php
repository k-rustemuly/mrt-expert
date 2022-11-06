<?php

namespace App\Mrt\Upload\Domain\Services;

use App\Mrt\Upload\Domain\Repositories\UploadRepository as Repository;
use App\Domain\Payloads\GenericPayload;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Exceptions\MainException;

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
        $extension = $file->extension(); // Determine the file's extension based on the file's MIME type...
        $realname = substr($name, 0, (strlen($extension)+1)*-1);
        $unique_name = $realname.' '.$file->hashName(); // Generate a unique, random name...
        $filepath = $this->generatePath();
        // $config = Config::get('filesystems.disks.s3');
        if(File::streamUpload($filepath, $unique_name, $file, false))
        {
            $path = $filepath."/".$unique_name;
            $url = route('file.download', ['locale' => 'ru', 'path' => $path, 'name' => $name]);
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
        throw new MainException("Error to upload file");
    }

    private function generatePath():string
    {
        return  "uploads/".date("Y/m/d");
    }
}
