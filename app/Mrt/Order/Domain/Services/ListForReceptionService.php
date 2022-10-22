<?php

namespace App\Mrt\Order\Domain\Services;

use App\Domain\Services\TableType;
use App\Mrt\Order\Domain\Repositories\OrderRepository as Repository;
use App\Helpers\FieldTypes\Number;
use App\Helpers\FieldTypes\Text;
use App\Helpers\FieldTypes\Reference;
use App\Helpers\Field;
use Illuminate\Support\Facades\App;
use App\Helpers\Action;

class ListForReceptionService extends TableType
{
    public $name = "order";

    protected $repository;

    public $headers;

    public $datas;

    public $actions;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($status_id = 0)
    {
        $user = auth('reception')->user();
        if(!$user){
            $user = auth('assistant')->user();
        }
        $this->headers = $this->getHeader();
        $this->datas = $this->repository->getByBranchId($user->branch_id, $status_id);
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
            "status_id" => Field::_()
                            ->init(new Reference())
                            ->key("status")
                            ->render(),
            "patient_name" => Field::_()
                            ->init(new Text())
                            ->render(),
            "reception_name" => Field::_()
                            ->init(new Text())
                            ->render(),
            "created" => Field::_()
                            ->init(new Text())
                            ->render(),
        ];
    }

    /**
     * действия для каждой строки
     *
     * @param string|int $order_id Айди
     *
     * @return array<mixed>
    */
    public function action($order_id = 0)
    {
        return [
            "view" =>  Action::_()
                ->requestType("view")
                ->requestUrl(route('reception.order.view', ['locale' => App::currentLocale(), 'order_id' => $order_id]))
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
