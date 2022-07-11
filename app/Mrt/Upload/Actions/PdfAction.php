<?php

namespace App\Mrt\Upload\Actions;

use App\Responders\JsonResponder as Responder;
// use PDF;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
class PdfAction
{

    public function __construct(Responder $responder)
    {
        $this->responder = $responder;
    }

    public function __invoke()
    {
        $data = [
            "name" => "aaa"
        ];
        $pdf = Pdf::loadView('empty', $data);
        // download PDF file with download method
        // Storage::put('public/pdf/invoice.pdf', $pdf->output());
        
        return $pdf->download('invoice.pdf');
    }
}