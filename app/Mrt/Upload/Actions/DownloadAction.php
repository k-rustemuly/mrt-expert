<?php

namespace App\Mrt\Upload\Actions;

use App\Domain\Requests\DefaultRequest as Request;
use Illuminate\Support\Facades\Storage;

class DownloadAction
{

    public function __construct(){
    }

    public function __invoke(Request $request)
    {
        return redirect(Storage::disk('s3')->temporaryUrl(
            $request->path,
            now()->addMinutes(60),
            ['ContentDisposition' => 'attachment; filename="'+$request->name+'"']
        ));
    }
}
