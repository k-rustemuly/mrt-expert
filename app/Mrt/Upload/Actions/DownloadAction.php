<?php

namespace App\Mrt\Upload\Actions;

use App\Domain\Requests\DefaultRequest as Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class DownloadAction
{

    public function __construct(){
    }

    public function __invoke(Request $request)
    {
        return redirect(config("filesystems.disks.s3.url").$request->path);
    }
}
