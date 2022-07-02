<?php

namespace App\Mrt\Doctor\Domain\Services;

use App\Domain\Services\BlockType;
use App\Mrt\Doctor\Domain\Repositories\DoctorRepository as Repository;
use App\Mrt\Subservice\Domain\Repositories\SubserviceRepository;
use App\Helpers\Action;
use App\Helpers\Block;
use App\Exceptions\MainException;
use Illuminate\Support\Facades\App;
use App\Helpers\Field;
use App\Helpers\FieldTypes\Text;
use App\Helpers\FieldTypes\Boolean;

class AboutService extends BlockType
{

    protected $repository;

    protected $subserviceRepository;

    public $name = "one_doctor";

    public $blocks;

    public $actions;

    public $headers;

    public $doctor_id;

    public function __construct(Repository $repository, SubserviceRepository $subserviceRepository)
    {
        $this->repository = $repository;
        $this->subserviceRepository = $subserviceRepository;
    }

    /**
     * @param string $doctor_id ID 
     */
    public function handle($doctor_id = 0)
    {
        $this->doctor_id = $doctor_id;

        $aboutDoctor = $this->repository->getById($doctor_id);
        if(empty($aboutDoctor)) throw new MainException("You dont have permission or record not found");

        $this->actions = $this->getActions();
        $this->headers = $this->getHeader($aboutDoctor);
        $this->blocks = array(
            "main_info" => Block::_()
                        ->values($this->getMainBlock($aboutDoctor))
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
                "full_name" => [
                    "value" => $values["full_name"],
                ],
                "email" => [
                    "value" => $values["email"],
                ],
                "subservices" => [
                    "type" => "reference",
                    "value" => $this->getSubservices($values["subservices"])
                ],
                "is_active" => [
                    "value" => __($values["is_active"] ? "yes" : "no"),
                ],
                "last_visit" => [
                    "value" => $values["last_visit"],
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
    private function getHeader(array $values = array())
    {
        return [
            "edit" => [
                "full_name" => Field::_()
                            ->init(new Text())
                            ->onUpdate("visible", true)
                            ->maxLength(255)
                            ->value($values["full_name"])
                            ->render(),
                "is_active" => Field::_()
                                ->init(new Boolean())
                                ->onUpdate("visible", true)
                                ->value(
                                    [
                                        "id" => $values["is_active"],
                                        "name" => __($values["is_active"] ? "yes" : "no")
                                    ]
                                )
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
            "default" => array(
                "edit" => 
                    Action::_()
                    ->requestType("put")
                    ->requestUrl(route('branch-admin.doctor.update', ['locale' => App::currentLocale(), 'doctor_id' => $this->doctor_id]))
                    ->type()
                    ->render(),
            )
        );
        return $actions[$type]??[];
    }

    private function parseSubservices(string $data = "")
    {
        $data_ids = array();
        if($data == "" || $data == null) return $data_ids;
        $ids = explode('@', $data);
        if(is_array($ids))
        {
            foreach($ids as $id)
            {
                if($id > 0)
                {
                    $data_ids[] = (int)$id;
                }
            }
        }
        return $data_ids;
    }

    private function getSubservices($subservices = null)
    {
        $ids = $this->parseSubservices($subservices);
        if(empty($ids)) return [];

        $list = array();
        $all = $this->subserviceRepository->getInList($ids);
        foreach($all as $item)
        {
            $list[] = ["id" => $item["id"], "name" => $item["name"]];
        }
        return $list;
    }
}