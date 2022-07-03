<?php

namespace App\Mrt\Order\Domain\Services;

use App\Domain\Services\TableType;
use App\Mrt\Order\Domain\Repositories\OrderRepository as Repository;
use App\Helpers\Action;
use App\Helpers\Block;
use App\Exceptions\MainException;
use Illuminate\Support\Facades\App;
use App\Helpers\Field;
use App\Helpers\FieldTypes\Text;

class SubserviceService extends TableType
{

    protected $repository;

    public $name = "one_order";

    public $datas;

    public $actions;

    public $headers;

    public $order_id;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $order_id ID 
     */
    public function handle($order_id = 0)
    {
        $this->order_id = $order_id;

        $this->actions = $this->getActions();
        $this->headers = $this->getHeader();
        $this->datas = array();
        return $this->getData();
    }

    /** 
     * действия для каждой строки
     * 
     * @param string|int $subservice_id Айди 
     * 
     * @return array<mixed>
    */
    public function action($subservice_id = 0)
    {
        return [];
    }

    /**
     * Заголовки
     * 
     * @param array $values
     * 
     * @return array<mixed>
     */
    private function getHeader()
    {
        return [
            "order_id" => Field::_()
                            ->init(new Text())
                            ->render(),
        ];
    }

    /**
     * @param string $type
     * 
     * @return array<mixed>
     */
    private function getActions($type = "default")
    {
        $actions = array(
            "default" => array(
                "create" =>  Action::_()
                            ->requestType("post")
                            ->requestUrl(route('reception.order.subservice.create', ['locale' => App::currentLocale(), 'order_id' => $this->order_id]))
                            ->type("success")
                            ->render(),
            )
        );
        return $actions[$type]??[];
    }
}