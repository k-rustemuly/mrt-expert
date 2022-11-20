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
        return redirect(Storage::disk('s3')->temporaryUrl(
            $request->path,
            now()->addMinutes(5),
            [
                'ResponseContentType' => 'application/octet-stream',
                'ResponseContentDisposition' => 'attachment; filename="'.utf8_encode($request->name).'"',
            ]
            ));
        return redirect(File::streamDownload($request->path, $request->name));
    }
}
