<?php

namespace App\Mrt\Order\Domain\Services;

use App\Domain\Services\BlockType;
use App\Mrt\Order\Domain\Repositories\OrderRepository as Repository;
use App\Helpers\Action;
use App\Helpers\Block;
use App\Exceptions\MainException;
use Illuminate\Support\Facades\App;
use App\Helpers\Field;
use App\Helpers\FieldTypes\Textarea;
use App\Helpers\FieldTypes\DateTime;
use App\Helpers\FieldTypes\Reference;
use Carbon\Carbon;

class AboutService extends BlockType
{

    protected $repository;

    public $name = "one_order";

    public $blocks;

    public $actions;

    public $headers;

    public $order_id;

    public $branch_id = 0;

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
        $user = auth('reception')->user();
        $this->branch_id = $user->branch_id;

        $aboutOrder = $this->repository->getById($order_id);
        if(empty($aboutOrder)) throw new MainException("You dont have permission or record not found");

        $this->actions = $this->getActions();
        $this->headers = $this->getHeader($aboutOrder);
        $this->blocks = array(
            "main_info" => Block::_()
                        ->values($this->getMainBlock($aboutOrder)),
            "subservice" => Block::_()
                        ->action($this->getActions("reception"))
                        ->values()
            );
        return $this->getData();
    }

    /** 
     * Главный блок
     * 
     * @param array<mixed> $values Данные для заполнение данных блока
     * 
     * @return array<mixed>
    */
    private function getMainBlock(array $values = array())
    {
        return [
                "id" => [
                    "value" => $values["id"],
                ],
                "iin" => [
                    "value" => $values["iin"],
                ],
                "patient_name" => [
                    "value" => $values["patient_name"],
                ],
                "email" => [
                    "value" => $values["email"],
                ],
                "phone_number" => [
                    "value" => $values["phone_number"],
                ],
                "status" => [
                    "value" => $values["status_name"],
                    "color" => $values["status_color"],
                ],
                "reception_name" => [
                    "value" => $values["reception_name"],
                ],
                "created_at" => [
                    "value" => Carbon::parse($values["created_at"])->locale(App::currentLocale())->timezone('Asia/Aqtau')->isoFormat('LLLL'),
                ],
                "updated_at" => [
                    "value" =>  Carbon::parse($values["updated_at"])->locale(App::currentLocale())->timezone('Asia/Aqtau')->isoFormat('LLLL'),
                ]
        ];
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
            "create_subservice" => [
                "subservice_id" => Field::_()
                                    ->init(new Reference("subservice"))
                                    ->referenceUrl(route('reference.branch_subservice', ['locale' => App::currentLocale(), 'branch_id' => $this->branch_id]))
                                    ->onUpdate("visible", true)
                                    ->render(),
                "appointment_date" => Field::_()
                                        ->init(new DateTime())
                                        ->onUpdate("visible", true)
                                        ->value(date("Y-m-d H:i"))
                                        ->render(),
                "reception_comment" => Field::_()
                                        ->init(new Textarea())
                                        ->onUpdate("visible")
                                        ->render(),
            ]
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
            "reception" => [
                "create_subservice" => 
                    Action::_()
                        ->requestType("post")
                        ->requestUrl(route('reception.order.subservice.create', ['locale' => App::currentLocale(), 'order_id' => $this->order_id]))
                        ->render(),
            ]
        );
        return $actions[$type]??[];
    }
}