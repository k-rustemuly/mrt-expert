<?php

namespace App\Mrt\Suborder\Domain\Services;

use App\Domain\Services\TableType;
use App\Mrt\Suborder\Domain\Repositories\SuborderRepository as Repository;
use App\Helpers\FieldTypes\Number;
use App\Helpers\FieldTypes\Text;
use App\Helpers\FieldTypes\Reference;
use App\Helpers\Field;
use Illuminate\Support\Facades\App;
use App\Helpers\Action;

class ListAllForReceptionService extends TableType
{
    public $name = "suborder";

    protected $repository;

    public $headers;

    public $datas;

    public $actions;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($start_date = "", $end_date = "")
    {
        $user = auth('reception')->user();
        $this->headers = $this->getHeader();
        $this->datas = $this->repository->getAllByDateRange($user->branch_id, $start_date, $end_date);
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
                        ->render(),
            "service_name" => Field::_()
                            ->init(new Text())
                            ->render(),
            "subservice_name" => Field::_()
                                ->init(new Text())
                                ->render(),
            "status_id" => Field::_()
                    ->init(new Reference())
                    ->key('status')
                    ->render(),
            "appointment_date" => Field::_()
                                ->init(new Text())
                                ->render(),
        ];
    }

    /** 
     * действия для каждой строки
     * 
     * @param string|int $suborder_id Айди 
     * 
     * @return array<mixed>
    */
    public function action($suborder_id = 0)
    {
        return [
            "view" =>  Action::_()
                ->requestType("view")
                ->requestUrl(route('reception.suborder.view', ['locale' => App::currentLocale(), 'suborder_id' => $suborder_id]))
                ->type("info")
                ->render(),
        ];
    }

    /**
     * Глобальные действии
     * 
     * @return array<mixed>
     */
    private function getAction()
    {
        return [
        ];
    }

}