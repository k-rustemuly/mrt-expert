<?php

namespace App\Mrt\Upload\Actions;

use App\Domain\Requests\DefaultRequest as Request;
use Illuminate\Support\Facades\File;

class DownloadAction
{

    public function __construct(){
    }

    public function __invoke(Request $request)
    {
        dd($request);
        return redirect(File::streamDownload($request->path, $request->name));
    }
}
