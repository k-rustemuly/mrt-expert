<?php

namespace App\Mrt\Upload\Actions;

use App\Mrt\Upload\Domain\Requests\UploadFormRequest as Request;
use App\Mrt\Upload\Domain\Services\LocalService as Service;
use App\Responders\JsonResponder as Responder;
use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Domain\Payloads\GenericPayload;

class PdfAction
{

    public function __construct(Responder $responder, Service $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(Request $request)
    {
        
    //$pdf = Pdf::loadView('conclusion', array("aaa"));
    return $this->responder->withResponse(
        new GenericPayload("aaa")
    )->respond();
    //return $pdf->save('invoice.pdf');
    }
}