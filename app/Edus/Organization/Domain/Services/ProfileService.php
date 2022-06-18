<?php

namespace App\Edus\Organization\Domain\Services;

use App\Domain\Services\BlockType;
use App\Edus\Organization\Domain\Repositories\OrganizationRepository as Repository;
use App\Edus\OrgDirection\Domain\Repositories\OrgDirectionRepository;
use App\Helpers\Action;
use App\Helpers\Block;
use App\Exceptions\MainException;
use Illuminate\Support\Facades\App;
use App\Edus\AccessStatus\Domain\Models\AccessStatus;
use App\Helpers\Field;
use App\Helpers\FieldTypes\Text;
use App\Helpers\FieldTypes\Reference;
use App\Helpers\FieldTypes\Boolean;
use App\Helpers\FieldTypes\Date;
use App\Helpers\FieldTypes\PhoneNumber;
use App\Helpers\FieldTypes\Email;
use App\Helpers\FieldTypes\Url;
use App\Helpers\FieldTypes\Map;
use App\Helpers\FieldTypes\Tag;
use App\Helpers\FieldTypes\Sign;
use App\Helpers\FieldTypes\Password;
use App\Helpers\FieldTypes\File;

class ProfileService extends BlockType
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
        $this->repository = $repository;
        $this->orgDirectionRepository = $orgDirectionRepository;
    }

    public function handle()
    {
        $user = auth('organization')->user();
        $this->organization_id = $user->organization_id;

        $aboutOrganization = $this->repository->getById($this->organization_id);
        if(empty($aboutOrganization)) throw new MainException("You dont have permission or record not found");

        if($aboutOrganization["access_status_id"] == AccessStatus::FILLED_IN) // Если статус "Заполняется", то такие кнопки будет отображаться 
        {
            $this->actions = $this->getActions("filled_in");
        }
        $this->headers = $this->getHeader($aboutOrganization);

        $this->blocks = array(
            "status" => Block::_()
                        ->values($this->getStatusBlock($aboutOrganization)),
            "basic" => Block::_()
                        ->action($this->getActions("basic"))
                        ->values($this->getBasicBlock($aboutOrganization)),
            "main_info" => Block::_()
                        ->status(BLOCK::EDITED)
                        ->action($this->getActions("main_info"))
                        ->values($this->getMainBlock($aboutOrganization)),
            "contact" => Block::_()
                        ->action($this->getActions("contact"))
                        ->values($this->getContactBlock($aboutOrganization)),
            "address" => Block::_()
                        ->action($this->getActions("address"))
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
                    "type" => "reference",
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
    private function getHeader(array $values)
    {
        return [
            "edit" => [
                "name_kk" => Field::_()
                            ->init(new Text())
                            ->value($values["name_kk"])
                            ->onUpdate("visible", true)
                            ->maxLength(255)
                            ->render(),
                "name_ru" => Field::_()
                            ->init(new Text())
                            ->value($values["name_ru"])
                            ->onUpdate("visible", true)
                            ->maxLength(255)
                            ->render(),
                "full_name_kk" => Field::_()
                                ->init(new Text())
                                ->value($values["full_name_kk"])
                                ->onUpdate("visible", true)
                                ->maxLength(255)
                                ->render(),
                "full_name_ru" => Field::_()
                                ->init(new Text())
                                ->value($values["full_name_ru"])
                                ->onUpdate("visible", true)
                                ->maxLength(255)
                                ->render(),
                "ownership_type_id" => Field::_()
                                    ->init(new Reference("ownership-type"))
                                    ->value(
                                        [
                                            "id" => $values["ownership_type_id"],
                                            "name" => $values["ownership_type_name"]
                                        ]
                                    )
                                    ->onUpdate("visible", true)
                                    ->render(),
                "departmental_affiliation_id" => Field::_()
                                                ->init(new Reference("departmental-affiliation"))
                                                ->value(
                                                    [
                                                        "id" => $values["departmental_affiliation_id"],
                                                        "name" => $values["departmental_affiliation_name"]
                                                    ]
                                                )
                                                ->onUpdate("visible", true)
                                                ->render(),
                "legal_form_id" => Field::_()
                                ->init(new Reference("legal-form"))
                                ->value(
                                    [
                                        "id" => $values["legal_form_id"],
                                        "name" => $values["legal_form_name"]
                                    ]
                                )
                                ->onUpdate("visible", true)
                                ->render(),
                "is_ppp" => Field::_()
                        ->init(new Boolean())
                        ->value(
                            [
                                "id" => $values["is_ppp"],
                                "name" => __($values["is_ppp"] ? "yes" : "no")
                            ]
                        )
                        ->onUpdate("visible", true)
                        ->render(),
                "opening_date" => Field::_()
                                ->init(new Date())
                                ->value($values["opening_date"])
                                ->maxDate(date("Y-m-d"))
                                ->isPicker(true)
                                ->onUpdate("visible", true)
                                ->render(),

            ],
            "edit_contact" => [
                "fax" => Field::_()
                    ->init(new PhoneNumber())
                    ->value($values["fax"])
                    ->maxLength(50)
                    ->onUpdate("visible")
                    ->render(),
                "work_phone" => Field::_()
                    ->init(new PhoneNumber())
                    ->value($values["work_phone"])
                    ->maxLength(50)
                    ->onUpdate("visible", true)
                    ->render(),
                "cellular_telephone" => Field::_()
                    ->init(new PhoneNumber())
                    ->value($values["cellular_telephone"])
                    ->maxLength(50)
                    ->onUpdate("visible", true)
                    ->render(),
                "email" => Field::_()
                    ->init(new Email())
                    ->maxLength(255)
                    ->value($values["email"])
                    ->onUpdate("visible", true)
                    ->render(),
                "site" => Field::_()
                    ->init(new Url())
                    ->maxLength(255)
                    ->value($values["site"])
                    ->onUpdate("visible")
                    ->render(),
            ],
            "edit_address" => [
                "postcode" => Field::_()
                            ->init(new Text())
                            ->value($values["postcode"])
                            ->onUpdate("visible", true)
                            ->maxLength(50)
                            ->render(),
                "territorial_affiliation_id" => Field::_()
                                    ->init(new Reference("territorial-affiliation"))
                                    ->value(
                                        [
                                            "id" => $values["territorial_affiliation_id"],
                                            "name" => $values["territorial_affiliation_name"]
                                        ]
                                    )
                                    ->onUpdate("visible", true)
                                    ->render(),
                "locality_part_id" => Field::_()
                                            ->init(new Reference("locality-part"))
                                            ->value(
                                                [
                                                    "id" => $values["locality_part_id"],
                                                    "name" => $values["locality_part_name"]
                                                ]
                                            )
                                            ->onUpdate("visible", true)
                                            ->render(),
                "locality_name" => Field::_()
                            ->init(new Text())
                            ->value($values["locality_name"])
                            ->onUpdate("visible", true)
                            ->maxLength(255)
                            ->render(),
                "house_number" => Field::_()
                            ->init(new Text())
                            ->value($values["house_number"])
                            ->onUpdate("visible", true)
                            ->maxLength(255)
                            ->render(),
                "map_coordinates" => Field::_()
                            ->init(new Map())
                            ->value($values["map_coordinates"])
                            ->onUpdate("visible", true)
                            ->maxLength(255)
                            ->render(),
            ],
            "edit_basic" => [
                "education_type_id" => Field::_()
                                    ->init(new Reference("education-type"))
                                    ->value(
                                        [
                                            "id" => $values["education_type_id"],
                                            "name" => $values["education_type_name"]
                                        ]
                                    )
                                    ->onUpdate("visible", true)
                                    ->render(),
                "direction" => Field::_()
                                ->init(new Reference("org-direction"))
                                ->maxSelect(-1)
                                ->value($this->getDirectionValues($values["direction"]))
                                ->onUpdate("visible", true)
                                ->render(),
            ],
            "to_check" => [
                "file" => Field::_()
                        ->init(new File())
                        ->onUpdate("visible", true)
                        ->maxFile(5)
                        ->render(),
                "p12" => Field::_()
                        ->init(new Sign())
                        ->onCreate("visible", true)
                        ->onUpdate("visible", true)
                        ->render(),
                "password" => Field::_()
                            ->init(new Password())
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
    private function getActions($type = "under_review")
    {
        $actions = array(
            "filled_in" => array(
                "to_check" => 
                    Action::_()
                    ->requestType("put")
                    ->requestUrl(route('organization.my.to_check', ['locale' => App::currentLocale()]))
                    ->type("success")
                    ->render(),
            ),
            "main_info" => array(
                "edit" => 
                    Action::_()
                    ->requestType("put")
                    ->requestUrl(route('organization.my.save', ['locale' => App::currentLocale()]))
                    ->render(),
            ),
            "contact" => array(
                "edit_contact" => 
                    Action::_()
                    ->requestType("put")
                    ->requestUrl(route('organization.my.save', ['locale' => App::currentLocale()]))
                    ->render(),
            ),
            "address" => array(
                "edit_address" => 
                    Action::_()
                    ->requestType("put")
                    ->requestUrl(route('organization.my.save', ['locale' => App::currentLocale()]))
                    ->render(),
            ),
            "basic" => array(
                "edit_basic" => 
                    Action::_()
                    ->requestType("put")
                    ->requestUrl(route('organization.my.save', ['locale' => App::currentLocale()]))
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
                $list[] = ["id" => $item["id"], "name" => $item["name"]];
            }
        }
        return $list;
    }
}