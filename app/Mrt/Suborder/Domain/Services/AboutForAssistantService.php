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
use App\Helpers\FieldTypes\Aws;
use App\Helpers\FieldTypes\DateTime;
use App\Helpers\FieldTypes\Reference;
use App\Helpers\FieldTypes\Textarea;
use Carbon\Carbon;
use App\Mrt\SuborderStatus\Domain\Models\SuborderStatus;
use App\Mrt\Doctor\Domain\Repositories\DoctorRepository;

class AboutForAssistantService extends BlockType
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
        $user = auth('assistant')->user();
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

        $aboutSuborder["additional_file"] = array();
        if($aboutSuborder["additional_file_url"])
        $aboutSuborder["additional_file"][] = [
            "id" => $aboutSuborder["additional_file_id"],
            "uuid" => $aboutSuborder["additional_file_uuid"],
            "url" => $aboutSuborder["additional_file_url"],
            "name" => $aboutSuborder["additional_file_name"],
        ];
        $this->actions = $this->getActions();
        $this->headers = $this->getHeader($aboutSuborder);

        $suborder_action = array();
        switch($aboutSuborder["status_id"])
        {
            case SuborderStatus::CREATED:
            case SuborderStatus::REVOKED:
            case SuborderStatus::REJECTED:
                $suborder_action = $this->getActions("created");
            break;
            case SuborderStatus::WAITING:
            case SuborderStatus::UNDER_TREATMENT:
                $suborder_action = $this->getActions("waiting");
            break;
        }
        $this->blocks = array(
            "order_info" => Block::_()
                        ->position("left")
                        ->values($this->getMainBlock($aboutOrder)),
            "suborder_info" => Block::_()
                        ->action($suborder_action)
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
            "send_to_doctor" => [
                "doctors" => Field::_()
                            ->init(new Reference("doctors"))
                            ->referenceUrl(route('assistant.suborder.doctors', ['locale' => App::currentLocale(), 'suborder_id' => $this->suborder_id]))
                            ->maxSelect(-1)
                            ->value($values["doctors"])
                            ->onUpdate("visible", true)
                            ->render(),
                "file" => Field::_()
                            ->init(new Aws())
                            ->accept(".zip,.rar")
                            ->onUpdate("visible", true)
                            ->value($values["file"])
                            ->render(),
                "assistant_comment" => Field::_()
                                ->init(new Textarea())
                                ->onUpdate("visible")
                                ->value($values["assistant_comment"])
                                ->render(),
                "additional_file" => Field::_()
                                ->init(new Aws())
                                // ->accept(".zip,.rar,.pdf,.jpg,.jpeg,.png,.docx,.doc")
                                ->accept(".zip,.rar,.pdf")
                                ->onUpdate("visible")
                                ->value($values["additional_file"])
                                ->render(),
            ],
            "update" => [
                "appointment_date" => Field::_()
                                    ->init(new DateTime())
                                    ->onUpdate("visible", true)
                                    ->value(date("Y-m-d H:i", strtotime($values["appointment_date"])))
                                    ->render(),
                "assistant_comment" => Field::_()
                                    ->init(new Textarea())
                                    ->onUpdate("visible")
                                    ->value($values["assistant_comment"])
                                    ->render(),
            ],
            "waiting_update" => [
                "assistant_comment" => Field::_()
                                    ->init(new Textarea())
                                    ->onUpdate("visible")
                                    ->value($values["assistant_comment"])
                                    ->render(),
            ],
            "cancel" => [
                "cancel_comment" => Field::_()
                                        ->init(new Textarea())
                                        ->onCreate("visible", true)
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
            "created" => array(
                "send_to_doctor" =>
                    Action::_()
                    ->type("success")
                    ->requestType("put")
                    ->requestUrl(route('assistant.suborder.send_to_doctor', ['locale' => App::currentLocale(), 'suborder_id' => $this->suborder_id]))
                    ->render(),
                "update" =>  Action::_()
                            ->type("info")
                            ->requestType("put")
                            ->requestUrl(route('assistant.suborder.update', ['locale' => App::currentLocale(), 'suborder_id' => $this->suborder_id]))
                            ->render(),
                "cancel" =>
                            Action::_()
                                    ->requestType("put")
                                    ->requestUrl(route('assistant.suborder.cancel', ['locale' => App::currentLocale(), 'suborder_id' => $this->suborder_id]))
                                    ->name(__($this->name.".suborder.cancel.name"))
                                    ->hint(__($this->name.".suborder.cancel.hint"))
                                    ->type("error")
                                    ->render(),
            ),
            "waiting" => array(
                // "waiting_update" =>  Action::_()
                //             ->type("info")
                //             ->requestType("put")
                //             ->requestUrl(route('assistant.suborder.update', ['locale' => App::currentLocale(), 'suborder_id' => $this->suborder_id]))
                //             ->render(),
                "revoke" =>  Action::_()
                            ->type("error")
                            ->requestType("put")
                            ->requestUrl(route('assistant.suborder.revoke', ['locale' => App::currentLocale(), 'suborder_id' => $this->suborder_id]))
                            ->render(),
            )
        );
        return $actions[$type]??[];
    }
}
