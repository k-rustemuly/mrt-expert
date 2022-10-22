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
use App\Helpers\FieldTypes\Textarea;
use Carbon\Carbon;
use App\Mrt\SuborderStatus\Domain\Models\SuborderStatus;
use App\Mrt\Doctor\Domain\Repositories\DoctorRepository;

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
        $this->headers = $this->getHeader($aboutSuborder);

        $this->blocks = array(
            "order_info" => Block::_()
                        ->values($this->getMainBlock($aboutOrder)),
            "suborder_info" => Block::_()
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
                "is_kmis" => [
                    "name" => __($this->name.".is_kmis"),
                    "value" => $values["is_kmis"] ? __("yes") : __("no")
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
        );
        return $actions[$type]??[];
    }
}
