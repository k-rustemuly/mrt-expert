<?php

namespace App\Mrt\Report\Domain\Services;

use App\Mrt\Suborder\Domain\Repositories\SuborderRepository as Repository;
use App\Mrt\Doctor\Domain\Repositories\DoctorRepository;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class FirstReportService implements WithMultipleSheets
{
    use Exportable;

    protected $repository;

    private $from_date;

    private $to_date;

    private $doctorRepository;

    private $doctorsMap;

    public function __construct(Repository $repository, DoctorRepository $doctorRepository)
    {
        $this->repository = $repository;
        $this->doctorRepository = $doctorRepository;
    }

    public function handle($data = array())
    {
        $this->from_date = $data["from_date"];
        $this->to_date = $data["to_date"];
        $doctors = $this->doctorRepository->getMin();
        foreach($doctors as $doctor){
            $this->doctorsMap[$doctor["id"]] = $doctor["full_name"];
        }
        return $this->download('МРТ ПАЦИЕНТЫ.xlsx');
    }

    private function parseDoctors($str = ""){
        $check = explode("@", $str);
        $ids = [];
        foreach($check as $id){
            if(is_numeric($id) && $id > 0) $ids[] = $this->doctorsMap[$id];
        }
        return $ids;
    }

    public function sheets(): array
    {
        $sheets = [];
        $startDate = new Carbon($this->from_date);
        $endDate = new Carbon($this->to_date);
        while ($startDate->lte($endDate)){
            $date = $startDate->toDateString();
            $suboders = $this->repository->firstReport($date);
            $to_sheet = [];
            for($i=0; $i<count($suboders); $i++){
                $to_sheet[$i]["num"] = $i+1;
                $to_sheet[$i]["date"] = Carbon::parse($suboders[$i]["created_at"])->format('Y-m-d');
                $to_sheet[$i]["full_name"] = $suboders[$i]["full_name"];
                $to_sheet[$i]["subservice_name"] = $suboders[$i]["subservice_name"];
                $to_sheet[$i]["sender"] = $suboders[$i]["sender"];
                $to_sheet[$i]["comment"] = "";
                $to_sheet[$i]["payment"] = "";
                $to_sheet[$i]["type"] = $suboders[$i]["is_kmis"] ? "кмис" : "";
                $to_sheet[$i]["phone_number"] = $suboders[$i]["phone_number"];
                $to_sheet[$i]["doctors"] = implode(",", $this->parseDoctors($suboders[$i]["doctors"]));
            }
            $sheets[] = new FirstReportSheet($date, $to_sheet);
            $startDate->addDay();
        }
        return $sheets;
    }
}

class FirstReportSheet implements FromArray, WithTitle, WithHeadings, ShouldAutoSize, WithEvents{
    private $date;
    private $data;

    public function __construct($date, $data)
    {
        $this->date = $date;
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return Carbon::parse($this->date)->format('d.m.Y');
    }

    public function headings(): array
    {
        return [
            '№',
            'ДАТА',
            'ФИО',
            'ВИД ИССЛЕДОВАНИЯ',
            'НАПРАВИЛ',
            'ПРИМЕЧАНИЕ',
            'ОПЛАТА',
            'ВИД ОПЛАТЫ',
            'ТЕЛЕФОНЫ',
            'ВРАЧИ',
        ];
    }

    public function registerEvents(): array
    {
        $alphabetRange = range('A', 'Z');
        $alphabet = $alphabetRange[count($this->headings())-1];
        $totalRow = count($this->array())+1;
        $cellRange = 'A1:'.$alphabet.$totalRow;
        $headerRange = 'A1:'.$alphabet.'1';
        return [
            AfterSheet::class    => function(AfterSheet $event) use ($cellRange, $headerRange)
            {
                $event->sheet->getDelegate()->getStyle($headerRange)->getFont()->setBold(true);
                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }
}
