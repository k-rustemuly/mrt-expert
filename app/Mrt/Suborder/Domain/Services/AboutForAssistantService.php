<?php

namespace App\Mrt\Suborder\Domain\Services;

use App\Domain\Services\BlockType;
use App\Mrt\Suborder\Domain\Repositories\SuborderRepository as Repository;
use App\Mrt\Order\Domain\Repositories\OrderRepository;
use App\Helpers\Action;
use App\Helpers\Block;
use App\Exceptions\MainException;
use Illuminate\Support\Facades\App;
use App\Helpers\Field;
use App\Helpers\FieldTypes\File;
use App\Helpers\FieldTypes\DateTime;
use App\Helpers\FieldTypes\Reference;
use Carbon\Carbon;
use App\Mrt\SuborderStatus\Domain\Models\SuborderStatus;

class AboutForAssistantService extends BlockType
{

    protected $repository;

    protected $orderRepository;

    public $name = "one_suborder";

    public $blocks;

    public $actions;

    public $headers;

    public $suborder_id;

    public $branch_id = 0;

    public function __construct(Repository $repository, OrderRepository $orderRepository)
    {
        $this->repository = $repository;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param string $suborder_id ID 
     */
    public function handle($suborder_id = 0)
    {
        $this->suborder_id = $suborder_id;
        $user = auth('assistant')->user();
        $this->branch_id = $user->branch_id;

        $aboutSuborder = $this->repository->getByBranchId($this->branch_id, $suborder_id);
        if(empty($aboutSuborder)) throw new MainException("You dont have permission or record not found");

        $aboutOrder = $this->orderRepository->getById($aboutSuborder["order_id"]);

        $this->actions = $this->getActions();
        $this->headers = $this->getHeader($aboutSuborder);
        $suborder_action = array();
        if($aboutSuborder["status_id"] == SuborderStatus::CREATED)
        {
            $suborder_action = $this->getActions("send_to_doctor");
        }
        $this->blocks = array(
            "order_info" => Block::_()
                        ->values($this->getMainBlock($aboutOrder)),
            "suborder_info" => Block::_()
                        ->action($suborder_action)
                        ->values($this->getSuborderBlock($aboutSuborder))
            );
        return $this->getData();
    }

    /** 
     * Подзаказы блок
     * 
     * @param array<mixed> $values Данные для заполнение данных блока
     * 
     * @return array<mixed>
    */
    private function getSuborderBlock(array $values = array())
    {
        return [
                "id" => [
                    "visibility" => "invisible",
                    "name" => __($this->name.".id"),
                    "value" => $values["id"],
                ],
                "service_name" => [
                    "name" => __($this->name.".service_name"),
                    "value" => $values["service_name"],
                ],
                "subservice_name" => [
                    "name" => __($this->name.".subservice_name"),
                    "value" => $values["subservice_name"],
                ],
                "status_name" => [
                    "name" => __($this->name.".status_name"),
                    "value" => $values["status_name"],
                    "color" => $values["status_color"],
                ],
                "appointment_date" => [
                    "name" => __($this->name.".appointment_date"),
                    "value" => Carbon::parse($values["appointment_date"])->locale(App::currentLocale())->timezone('Asia/Aqtau')->isoFormat('LLLL'),
                ],
                "reception_comment" => [
                    "name" => __($this->name.".reception_comment"),
                    "value" => $values["reception_comment"],
                ],
                "assistant_comment" => [
                    "name" => __($this->name.".assistant_comment"),
                    "value" => $values["assistant_comment"],
                ],
                "created_at" => [
                    "name" => __($this->name.".created_at"),
                    "value" => Carbon::parse($values["created_at"])->locale(App::currentLocale())->timezone('Asia/Aqtau')->isoFormat('LLLL'),
                ],
                "updated_at" => [
                    "name" => __($this->name.".updated_at"),
                    "value" =>  Carbon::parse($values["updated_at"])->locale(App::currentLocale())->timezone('Asia/Aqtau')->isoFormat('LLLL'),
                ]
        ];
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
            "send_to_doctor" => [
                "doctors" => Field::_()
                            ->init(new Reference("doctors"))
                            ->referenceUrl(route('assistant.suborder.doctors', ['locale' => App::currentLocale(), 'suborder_id' => $this->suborder_id]))
                            ->maxSelect(-1)
                            ->onUpdate("visible", true)
                            ->render(),
                "file" => Field::_()
                                ->init(new File())
                                ->allowExt("zip,rar")
                                ->onUpdate("visible", true)
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
            "send_to_doctor" => array(
                "send_to_doctor" => 
                    Action::_()
                    ->requestType("post")
                    // ->requestUrl(route('reception.patient.update', ['locale' => App::currentLocale(), 'patient_id' => $this->patient_id]))
                    ->requestUrl('test')
                    ->render(),
            )
        );
        return $actions[$type]??[];
    }
}