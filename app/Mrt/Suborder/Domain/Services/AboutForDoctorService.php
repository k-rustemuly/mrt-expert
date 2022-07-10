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
use App\Helpers\FieldTypes\Text;
use App\Helpers\FieldTypes\Html;
use Carbon\Carbon;
use App\Mrt\SuborderStatus\Domain\Models\SuborderStatus;
use App\Mrt\Doctor\Domain\Repositories\DoctorRepository;
use App\Mrt\Branch\Domain\Repositories\BranchRepository;

class AboutForDoctorService extends BlockType
{

    protected $repository;

    protected $orderRepository;

    protected $doctorRepository;

    protected $branchRepository;

    public $name = "one_suborder";

    public $blocks;

    public $actions;

    public $headers;

    public $suborder_id;

    public $doctor_id = 0;

    public function __construct(Repository $repository, OrderRepository $orderRepository, DoctorRepository $doctorRepository, BranchRepository $branchRepository)
    {
        $this->repository = $repository;
        $this->orderRepository = $orderRepository;
        $this->doctorRepository = $doctorRepository;
        $this->branchRepository = $branchRepository;
    }

    /**
     * @param string $suborder_id ID 
     */
    public function handle($suborder_id = 0)
    {
        $this->suborder_id = $suborder_id;
        $user = auth('doctor')->user();
        $this->doctor_id = $user->id;

        $aboutSuborder = $this->repository->getAllByDoctorId($this->doctor_id, $suborder_id);
        if(empty($aboutSuborder)) throw new MainException("You dont have permission or record not found");

        $aboutOrder = $this->orderRepository->getById($aboutSuborder["order_id"]);
        $aboutBranch = $this->branchRepository->getFullInfoById($aboutSuborder["branch_id"]);

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
        
        $this->actions = $this->getActions();
        $this->headers = $this->getHeader($aboutOrder);
        
        $suborder_action = array();
        switch($aboutSuborder["status_id"])
        {
            case SuborderStatus::WAITING:
                $suborder_action = $this->getActions("waiting");
            break;
            case SuborderStatus::UNDER_TREATMENT:
                $suborder_action = $this->getActions("under_treatment");
            break;
        }
        $this->blocks = array(
            "branch_info" => Block::_()
                            ->values($this->getBranchBlock($aboutBranch)),
            "order_info" => Block::_()
                        ->values($this->getMainBlock($aboutOrder)),
            "suborder_info" => Block::_()
                        ->action($suborder_action)
                        ->values($this->getSuborderBlock($aboutSuborder))
            );
        return $this->getData();
    }
    /** 
     * Филиал блок
     * 
     * @param array<mixed> $values Данные для заполнение данных блока
     * 
     * @return array<mixed>
    */
    private function getBranchBlock(array $values = array())
    {
        return [
                "branch_name" => [
                    "value" => $values["name"],
                ],
                "punkt_name" => [
                    "value" => $values["punkt_name"],
                ]
        ];
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
                "reception_comment" => [
                    "name" => __($this->name.".reception_comment"),
                    "value" => $values["reception_comment"],
                ],
                "assistant_comment" => [
                    "name" => __($this->name.".assistant_comment"),
                    "value" => $values["assistant_comment"],
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
            "submit" => [
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
                                ->onUpdate("visible", true)
                                ->render(),
                "conclusion" => Field::_()
                                ->init(new Html())
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
            "under_treatment" => array(
                "submit" =>  Action::_()
                            ->type("success")
                            ->requestType("put")
                            ->requestUrl(route('doctor.suborder.submit', ['locale' => App::currentLocale(), 'suborder_id' => $this->suborder_id]))
                            ->render(),
                "reject" =>  Action::_()
                            ->type("error")
                            ->requestType("put")
                            ->requestUrl(route('doctor.suborder.reject', ['locale' => App::currentLocale(), 'suborder_id' => $this->suborder_id]))
                            ->render(),
            ),
            "waiting" => array(
                "under_treatment" =>  Action::_()
                            ->type("info")
                            ->requestType("put")
                            ->requestUrl(route('doctor.suborder.under_treatment', ['locale' => App::currentLocale(), 'suborder_id' => $this->suborder_id]))
                            ->render(),
            )
        );
        return $actions[$type]??[];
    }
}