<?php

namespace App\Edus\Organization\Domain\Services;

use App\Domain\Services\BlockType;
use App\Edus\OrgDirection\Domain\Repositories\OrgDirectionRepository;
use App\Edus\Organization\Domain\Repositories\OrganizationRepository as Repository;
use App\Helpers\Action;
use App\Helpers\Block;
use App\Exceptions\MainException;
use Illuminate\Support\Facades\App;
use App\Edus\AccessStatus\Domain\Models\AccessStatus;
use App\Helpers\Field;
use App\Helpers\FieldTypes\Text;

class AboutService extends BlockType
{

    protected $repository;

    protected $orgDirectionRepository;

    public $name = "one_organization";

    public $blocks;

    public $actions;

    public $headers;

    public $organization_id;

    public function __construct(Repository $repository, OrgDirectionRepository $orgDirectionRepository)
    {
        $this->orgDirectionRepository = $orgDirectionRepository;
        $this->repository = $repository;
    }

    /**
     * @param string $organization_id ID место 
     */
    public function handle($organization_id = 0)
    {
        $this->organization_id = $organization_id;
        $punkt_id = 0;
        $admin = auth()->user();
        if(isset($admin->punkt_id))
        {
            $punkt_id = $admin->punkt_id;
        } 

        $aboutOrganization = $this->repository->getById($organization_id);
        if(empty($aboutOrganization) || $aboutOrganization["punkt_id"] != $punkt_id) throw new MainException("You dont have permission or record not found");
        

        if($punkt_id > 0 && $aboutOrganization["access_status_id"] == AccessStatus::UNDER_REVIEW) // Если зашел пользователь отдела образования и статус "На проверке", то такие кнопки будет отображаться 
        {
            $this->actions = $this->getActions("under_review");
        }
        $this->headers = $this->getHeader();

        $this->blocks = array(
            "status" => Block::_()
                        ->values($this->getStatusBlock($aboutOrganization)),
            "basic" => Block::_()
                        ->values($this->getBasicBlock($aboutOrganization)),
            "main_info" => Block::_()
                        ->values($this->getMainBlock($aboutOrganization)),
            "contact" => Block::_()
                        ->values($this->getContactBlock($aboutOrganization)),
            "address" => Block::_()
                        ->values($this->getAddressBlock($aboutOrganization)),
            "organization_files" => Block::_()
                        ->values()
            );
        return $this->getData();
    }

    /** 
     * Статусный блок
     * 
     * @param array<mixed> $values Данные для заполнение данных блока
     * 
     * @return array<mixed>
    */
    private function getBasicBlock(array $values = array())
    {
        return [
                "education_type_name" => [
                    "value" => $values["education_type_name"],
                ],
                "direction" => [
                    "type" => "tag",
                    "value" => $this->getDirectionValues($values["direction"]),
                ]
        ];
    }

    /** 
     * Основные данные
     * 
     * @param array<mixed> $values Данные для заполнение данных блока
     * 
     * @return array<mixed>
    */
    private function getStatusBlock(array $values = array())
    {
        return [
                "access_status" => [
                    "type" => "reference",
                    "value" => [
                        "id" => $values["access_status_id"],
                        "name" => $values["access_status_name"]
                    ],
                    "color" => $values["access_status_color"],
                ],
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
                "bin" => [
                    "value" => $values["bin"],
                ],
                "is_ip" => [
                    "value" => __($values["is_ip"] ? "yes" : "no"),
                ],
                "name_kk" => [
                    "value" => $values["name_kk"],
                ],
                "name_ru" => [
                    "value" => $values["name_ru"],
                ],
                "full_name_kk" => [
                    "value" => $values["full_name_kk"],
                ],
                "full_name_ru" => [
                    "value" => $values["full_name_ru"],
                ],
                "ownership_type_name" => [
                    "value" => $values["ownership_type_name"],
                ],
                "departmental_affiliation_name" => [
                    "value" => $values["departmental_affiliation_name"],
                ],
                "legal_form_name" => [
                    "value" => $values["legal_form_name"],
                ],
                "is_ppp" => [
                    "value" => __($values["is_ppp"] ? "yes" : "no"),
                ],
                "opening_date" => [
                    "value" => $values["opening_date"],
                ],
                "oked_code" => [
                    "value" => $values["oked_code"],
                ],
                "krp_code" => [
                    "value" => $values["krp_code"],
                ],
                "director_fullname" => [
                    "value" => $values["director_fullname"],
                ]
        ];
    }

    /** 
     * Контакты блок
     * 
     * @param array<mixed> $values Данные для заполнение данных блока
     * 
     * @return array<mixed>
    */
    private function getContactBlock(array $values = array())
    {
        return [
                "fax" => [
                    "value" => $values["fax"],
                ],
                "work_phone" => [
                    "value" => $values["work_phone"],
                ],
                "cellular_telephone" => [
                    "value" => $values["cellular_telephone"],
                ],
                "email" => [
                    "value" => $values["email"],
                ],
                "site" => [
                    "value" => $values["site"],
                ]
        ];
    }

    /** 
     * Адресный блок
     * 
     * @param array<mixed> $values Данные для заполнение данных блока
     * 
     * @return array<mixed>
    */
    private function getAddressBlock(array $values = array())
    {
        return [
                "kato_code" => [
                    "value" => $values["kato_code"],
                ],
                "postcode" => [
                    "value" => $values["postcode"],
                ],
                "territorial_affiliation_name" => [
                    "value" => $values["territorial_affiliation_name"],
                ],
                "locality_part_name" => [
                    "value" => $values["locality_part_name"],
                ],
                "locality_name" => [
                    "value" => $values["locality_name"],
                ],
                "house_number" => [
                    "value" => $values["house_number"],
                ],
                "map_coordinates" => [
                    "value" => $values["map_coordinates"],
                ]
        ];
    }

    /**
     * Заголовки
     * 
     * @return array<mixed>
     */
    private function getHeader()
    {
        return [
            "reject" => [
                "comment" => Field::_()->init(new Text())->onUpdate("visible", true)->minLength(5)->maxLength(255)->render(),
            ]
        ];
    }

    /**
     * @param string $type
     * 
     * @return array<mixed>
     */
    private function getActions($type = "under_review")
    {
        $actions = array(
            "under_review" => array(
                "accept" => 
                    Action::_()
                    ->requestType("put")
                    ->requestUrl(route('department.organization.accept', ['locale' => App::currentLocale(), 'organization_id' => $this->organization_id]))
                    ->type("success")
                    ->render(),
                "reject" => 
                    Action::_()
                    ->requestType("put")
                    ->requestUrl(route('department.organization.reject', ['locale' => App::currentLocale(), 'organization_id' => $this->organization_id]))
                    ->type("error")
                    ->render(),
            )
        );
        return $actions[$type]??[];
    }

    private function parseDirection(string $direction = "")
    {
        $direction_ids = array();
        $ids = explode('@', $direction);
        if(is_array($ids))
        {
            foreach($ids as $id)
            {
                if($id > 0)
                {
                    $direction_ids[] = (int)$id;
                }
            }
        }
        return $direction_ids;
    }

    private function getDirectionValues(string $direction = "")
    {
        $ids = $this->parseDirection($direction);
        $list = array();
        if(!empty($ids))
        {
            $all = $this->orgDirectionRepository->getInList($ids);
            foreach($all as $item)
            {
                $list[] = $item["name"];
            }
        }
        return $list;
    }
}