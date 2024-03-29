<?php

namespace App\Mrt\Suborder\Domain\Services;

use App\Domain\Services\BlockType;
use App\Mrt\Suborder\Domain\Repositories\SuborderRepository as Repository;
use App\Mrt\Order\Domain\Repositories\OrderRepository;
use App\Helpers\Block;
use App\Exceptions\MainException;
use Illuminate\Support\Facades\App;
use App\Helpers\Field;
use App\Helpers\FieldTypes\Textarea;
use Carbon\Carbon;
use App\Helpers\Action;
use App\Mrt\SuborderStatus\Domain\Models\SuborderStatus;
use App\Mrt\Doctor\Domain\Repositories\DoctorRepository;
use App\Helpers\FieldTypes\Text;
use App\Helpers\FieldTypes\Html;

class AboutForReceptionService extends BlockType
{

    protected $repository;

    protected $orderRepository;

    protected $doctorRepository;

    public $name = "one_suborder";

    public $blocks;

    public $actions;

    public $headers;

    public $suborder_id;

    public $branch_id = 0;

    public $title;

    public function __construct(Repository $repository, OrderRepository $orderRepository, DoctorRepository $doctorRepository)
    {
        $this->repository = $repository;
        $this->orderRepository = $orderRepository;
        $this->doctorRepository = $doctorRepository;
    }

    /**
     * @param string $suborder_id ID
     */
    public function handle($suborder_id = 0)
    {
        $this->suborder_id = $suborder_id;
        $user = auth('reception')->user();
        $this->branch_id = $user->branch_id;

        $aboutSuborder = $this->repository->getByBranchId($this->branch_id, $suborder_id);
        if(empty($aboutSuborder)) throw new MainException("You dont have permission or record not found");

        $aboutOrder = $this->orderRepository->getById($aboutSuborder["order_id"]);

        $doctor_ids = $aboutSuborder["doctors"] ? explode("@", $aboutSuborder["doctors"]) : [];
        $doctors = array();
        foreach ($doctor_ids as $id)
        {
            if($id > 0)
            {
                $doctor = $this->doctorRepository->getById($id);
                $doctors[] = [
                    "id" => $id,
                    "name" => $doctor["full_name"],
                ];
            }
        }
        $aboutSuborder["doctors"] = $doctors;

        $aboutSuborder["file"] = array();
        if($aboutSuborder["file_id"] && $aboutSuborder["file_id"] > 0)
        {
            $aboutSuborder["file"][] = [
                "id" => $aboutSuborder["file_id"],
                "uuid" => $aboutSuborder["file_uuid"],
                "url" => $aboutSuborder["file_url"],
                "name" => $aboutSuborder["file_name"],
            ];
        }
        $aboutSuborder["conclusion_file"][] = $aboutSuborder["conclusion_file_url"] ? [
            "url" => $aboutSuborder["conclusion_file_url"],
            "name" => $aboutSuborder["conclusion_file_name"],
        ] : null;

        $aboutSuborder["additional_file"][] = $aboutSuborder["additional_file_url"] ? [
            "url" => $aboutSuborder["additional_file_url"],
            "name" => $aboutSuborder["additional_file_name"],
        ] : null;

        $to_header = [
            "iin" => $aboutOrder["iin"],
            "patient_name" => $aboutOrder["patient_name"],
            "research" => $aboutSuborder["research"],
            "conclusion" => $aboutSuborder["conclusion"]
        ];
        $this->headers = $this->getHeader($to_header);

        $suborder_action_name = "default";
        if($aboutSuborder["status_id"] == SuborderStatus::CREATED){
            $suborder_action_name = "created";
        }else if($aboutSuborder["status_id"] == SuborderStatus::COMPLETED){
            $suborder_action_name = "completed";
        }
        $this->blocks = array(
            "order_info" => Block::_()
                        ->position("left")
                        ->values($this->getMainBlock($aboutOrder)),
            "suborder_info" => Block::_()
                            ->action($this->getActions($suborder_action_name))
                            ->values($this->getSuborderBlock($aboutSuborder))
            );
        $this->title = $aboutOrder["patient_name"];
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
                "is_kmis" => [
                    "name" => __($this->name.".is_kmis"),
                    "value" => $values["is_kmis"] ? __("yes") : __("no")
                ],
                "sender" => [
                    "name" => __($this->name.".sender"),
                    "value" => $values["sender"],
                ],
                "status_name" => [
                    "name" => __($this->name.".status_name"),
                    "value" => $values["status_name"],
                    "color" => $values["status_color"],
                ],
                "conclusion_file" => [
                    "type" => "file",
                    "name" => __($this->name.".conclusion_file"),
                    "value" => $values["conclusion_file"],
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
                "doctors" => [
                    "type" => "reference",
                    "name" => __($this->name.".doctors"),
                    "value" => $values["doctors"],
                ],
                "doctor_comment" => [
                    "name" => __($this->name.".doctor_comment"),
                    "value" => $values["doctor_comment"],
                ],
                "file" => [
                    "type" => "file",
                    "name" => __($this->name.".file"),
                    "value" => $values["file"],
                ],
                "additional_file" => [
                    "type" => "file",
                    "name" => __($this->name.".additional_file"),
                    "value" => $values["additional_file"],
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
                "birthday" => [
                    "value" => $values["birthday"]
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
    private function getHeader($values = array())
    {
        return [
            "cancel" => [
                "cancel_comment" => Field::_()
                                        ->init(new Textarea())
                                        ->onCreate("visible", true)
                                        ->onUpdate("visible", true)
                                        ->render(),
            ],
            "edit" => [
                "iin" => Field::_()
                        ->init(new Text())
                        ->onUpdate("disabled")
                        ->value($values["iin"])
                        ->render(),
                "patient_name" => Field::_()
                                ->init(new Text())
                                ->onUpdate("disabled")
                                ->value($values["patient_name"])
                                ->render(),
                "research" => Field::_()
                                ->init(new Html())
                                ->rows(12)
                                ->onUpdate("visible", true)
                                ->value($values["research"])
                                ->render(),
                "conclusion" => Field::_()
                                ->init(new Html())
                                ->rows(12)
                                ->value($values["conclusion"])
                                ->onUpdate("visible", true)
                                ->render(),

            ],
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
            "created" => [
                "cancel" =>
                            Action::_()
                                    ->requestType("put")
                                    ->requestUrl(route('reception.suborder.cancel', ['locale' => App::currentLocale(), 'suborder_id' => $this->suborder_id]))
                                    ->name(__($this->name.".suborder.cancel.name"))
                                    ->hint(__($this->name.".suborder.cancel.hint"))
                                    ->type("error")
                                    ->render(),
            ],
            "completed" => [
                "edit" =>
                        Action::_()
                                ->requestType("put")
                                ->requestUrl(route('reception.suborder.edit', ['locale' => App::currentLocale(), 'suborder_id' => $this->suborder_id]))
                                ->name(__($this->name.".suborder.edit.name"))
                                ->hint(__($this->name.".suborder.edit.hint"))
                                ->type("error")
                                ->render(),
            ]
        );
        return $actions[$type]??[];
    }
}
