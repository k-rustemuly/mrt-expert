<?php

namespace App\Mrt\Patient\Domain\Services;

use App\Domain\Services\TableType;
use App\Mrt\Patient\Domain\Repositories\PatientRepository as Repository;
use App\Helpers\FieldTypes\Email;
use App\Helpers\FieldTypes\Text;
use App\Helpers\FieldTypes\Date;
use App\Helpers\FieldTypes\Number;
use App\Helpers\FieldTypes\PhoneNumber;
use App\Helpers\FieldTypes\Boolean;
use App\Helpers\Field;
use Illuminate\Support\Facades\App;
use App\Helpers\Action;

class ListService extends TableType
{
    public $name = "patient";

    protected $repository;

    public $headers;

    public $datas;

    public $actions;

    public $paginations;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle()
    {
        $this->headers = $this->getHeader();
        // $this->datas = $this->repository->getAll()->jsonPaginate();
        $pagination = $this->repository->getByPage();
        $this->datas = $pagination["data"];
        unset($pagination["data"]);
        $this->paginations = $pagination;
        $this->actions = $this->getAction();
        return $this->getData();
    }

    /**
     * Заголовки
     * 
     * @return array<mixed>
     */
    private function getHeader()
    {
        return [
            "iin" => Field::_()
                        ->init(new Number())
                        ->onCreate("visible", true)
                        ->onUpdate("visible")
                        ->minLength(12)
                        ->maxLength(12)
                        ->render(),
            "whithout_iin" => Field::_()
                        ->init(new Boolean())
                        ->onCreate("visible")
                        ->onUpdate("visible")
                        ->onView("invisible")
                        ->render(),
            "full_name" => Field::_()
                            ->init(new Text())
                            ->onCreate("visible", true)
                            ->onUpdate("visible", true)
                            ->maxLength(255)
                            ->render(),
            "phone_number" => Field::_()
                                ->init(new PhoneNumber())
                                ->onCreate("visible", true)
                                ->onUpdate("visible", true)
                                ->minLength(16)
                                ->maxLength(16)
                                ->render(),
            "birthday" => Field::_()
                        ->init(new Date())
                        ->onCreate("visible")
                        ->onUpdate("visible")
                        ->maxLength(255)
                        ->render(),
            "email" => Field::_()
                        ->init(new Email())
                        ->onCreate("visible")
                        ->onUpdate("visible")
                        ->maxLength(255)
                        ->render(),
        ];
    }

    /** 
     * действия для каждой строки
     * 
     * @param string|int $patient_id Айди 
     * 
     * @return array<mixed>
    */
    public function action($patient_id = 0)
    {
        return [
            "view" =>  Action::_()
                ->requestType("get")
                ->requestUrl(route('reception.patient.view', ['locale' => App::currentLocale(), 'patient_id' => $patient_id]))
                ->type("info")
                ->render(),
        ];
    }

    /**
     * Глабольные действии
     * 
     * @return array<mixed>
     */
    private function getAction()
    {
        return [
            "create" =>  Action::_()
                ->requestType("post")
                ->requestUrl(route('reception.patient.create', ['locale' => App::currentLocale()]))
                ->type("success")
                ->afterResponse("open_result")
                ->render(),
        ];
    }

}