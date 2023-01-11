<?php

namespace App\Mrt\Suborder\Domain\Services;

use App\Domain\Services\TableType;
use App\Mrt\Suborder\Domain\Repositories\SuborderRepository as Repository;
use App\Helpers\FieldTypes\Number;
use App\Helpers\FieldTypes\Text;
use App\Helpers\Field;
use Illuminate\Support\Facades\App;
use App\Helpers\Action;

class ListForDoctorService extends TableType
{
    public $name = "suborder";

    protected $repository;

    public $headers;

    public $datas;

    public $actions;

    public $status_id;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($status_id = 0, $filter = array())
    {
        $this->status_id = $status_id;
        $user = auth('doctor')->user();
        $this->headers = $this->getHeader();
        $this->datas = $this->repository->getAllByDoctorIdAndStatusId($user->id, $status_id, $filter);
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
            "id" => Field::_()
                            ->init(new Number())
                            ->render(),
            "full_name" => Field::_()
                            ->init(new Text())
                            ->toSort()
                            ->render(),
            "service_name" => Field::_()
                            ->init(new Text())
                            ->render(),
            "subservice_name" => Field::_()
                            ->init(new Text())
                            ->render(),
            "appointment_date" => Field::_()
                            ->init(new Text())
                            ->toSort()
                            ->render(),
        ];
    }

    /**
     * действия для каждой строки
     *
     * @param array|object $object
     *
     * @return array<mixed>
    */
    public function action($object = null)
    {
        $array = [];
        if($object["status_id"] == 2)
            $array["accept"] = Action::_()
                                ->requestType("put")
                                ->requestUrl(route('doctor.suborder.under_treatment', ['locale' => App::currentLocale(), 'suborder_id' => $object["id"]]))
                                ->type("success")
                                ->hint(__("acceptByDoctor"))
                                ->afterResponse("delete_row")
                                ->render();
        return array_merge($array, [
            "download" => Action::_()
                        ->requestType("download")
                        ->requestUrl($object["url"])
                        ->type("success")
                        ->hint(__("downloadApplication"))
                        ->render(),
            "view" => Action::_()
                    ->requestType("view")
                    ->requestUrl(route('doctor.suborder.view', ['locale' => App::currentLocale(), 'suborder_id' => $object["id"]]))
                    ->type("info")
                    ->hint(__("openOnNewTab"))
                    ->render(),
        ]);
    }

    /**
     * Глобальные действии
     *
     * @return array<mixed>
     */
    private function getAction()
    {
        return [
            "accept_all" =>  Action::_()
                            ->requestType("put")
                            ->requestUrl(route('doctor.suborder.under_treatment_all', ['locale' => App::currentLocale()]))
                            ->type("success")
                            ->render(),
        ];
    }

}
