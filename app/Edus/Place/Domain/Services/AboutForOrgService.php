<?php

namespace App\Edus\Place\Domain\Services;

use App\Domain\Services\BlockType;
use App\Edus\Place\Domain\Repositories\PlaceRepository as Repository;
use App\Helpers\Action;
use App\Helpers\Block;
use App\Helpers\Field;
use App\Helpers\FieldTypes\Reference;
use App\Helpers\FieldTypes\Number;
use App\Helpers\FieldTypes\Double;
use App\Helpers\FieldTypes\DateTime;
use App\Exceptions\MainException;
use App\Edus\PlaceStatus\Domain\Models\PlaceStatus;
use Illuminate\Support\Facades\App;

class AboutForOrgService extends BlockType
{

    protected $repository;

    public $name = "one_place";

    public $blocks;

    public $actions;

    public $headers;

    public $datas;

    public $place_id;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $place_id ID место 
     */
    public function handle($place_id = 0)
    {
        $this->place_id = $place_id;
        $punkt_id = 0;
        $admin = auth()->user();
        if(isset($admin->punkt_id))
        {
            $punkt_id = $admin->punkt_id;
        }

        $aboutPlace = $this->repository->getOne($place_id, $punkt_id);
        if(empty($aboutPlace)) throw new MainException("You dont have permission or record not found");

        if($punkt_id > 0 && $aboutPlace["place_status_id"] == PlaceStatus::DRAFT) // Если зашел пользователь отдела образования и статус заявки еще "черновик", то такие кнопки будет отображаться 
        {
            $this->actions = $this->getActions("draft");
            $this->headers = $this->getHeader();
            $this->datas = $aboutPlace;
        }

        $this->blocks = array(
            "main_info" => Block::_()->values($this->getMainBlock($aboutPlace)),
        );
        return $this->getData();
    }

    /** 
     * Главный блок об одном месте
     * 
     * @param array<mixed> $values Данные для заполнение данных блока
     * 
     * @return array<mixed>
    */
    private function getMainBlock(array $values = array())
    {
        return [
                "punkt" => [
                    "value" => $values["punkt_name"],
                ],
                "club_category" => [
                    "value" => $values["club_category_name"],
                ],
                "club_subcategory" => [
                    "value" => $values["club_subcategory_name"],
                ],
                "quantity" => [
                    "value" => $values["quantity"],
                ],
                "amount" => [
                    "value" => $values["amount"],
                ],
                "place_type" => [
                    "value" => $values["place_type_name"],
                ],
                "place_status" => [
                    "value" => $values["place_status_name"],
                    "color" => $values["place_status_color"],
                ],
                "author" => [
                    "value" => $values["author_name"],
                ],
                "start_date_of_applications" => [
                    "value" => $values["start_date"],
                ],
                "end_date_of_applications" => [
                    "value" => $values["end_date"],
                ],
        ];
    }

    /**
     * Заголовки для изменение записи
     * 
     * @return array<mixed>
     */
    private function getHeader()
    {
        return [
            "update" => [
                "club_category_id" => Field::_()->init(new Reference("club-category"))->key("club_category")->onUpdate("visible", true)->render(),
                "club_subcategory_id" => Field::_()->init(new Reference("club-subcategory"))->link("club_category_id")->key("club_subcategory")->onUpdate("visible", true)->render(),
                "quantity" => Field::_()->init(new Number())->onUpdate("visible", true)->min(1)->render(),
                "amount" => Field::_()->init(new Double())->onUpdate("visible", true)->min(1)->render(),
                "place_type_id" => Field::_()->init(new Reference("place-type"))->key("place_type")->onUpdate("visible", true)->render(),
                "start_date" => Field::_()->init(new DateTime())->minDate(date("Y-m-d H:i:s"))->onUpdate("visible", true)->render(),
                "end_date" => Field::_()->init(new DateTime())->link("start_date")->onUpdate("visible", true)->render(),
            ]
        ];
    }

    /**
     * @param string $type
     * 
     * @return array<mixed>
     */
    private function getActions($type = "draft")
    {
        $actions = array(
            "draft" => array(
                "publish" => 
                    Action::_()
                    ->requestType("put")
                    ->requestUrl(route('department.place.publish', ['locale' => App::currentLocale(), 'place_id' => $this->place_id]))
                    ->type("success")
                    ->render(),
                "update" => 
                    Action::_()
                    ->requestType("put")
                    ->requestUrl(route('department.place.update', ['locale' => App::currentLocale(), 'place_id' => $this->place_id]))
                    ->type("warning")
                    ->render(),
                "delete" => 
                    Action::_()
                    ->requestType("delete")
                    ->requestUrl(route('department.place.delete', ['locale' => App::currentLocale(), 'place_id' => $this->place_id]))
                    ->type("error")
                    ->afterResponse("back")
                    ->render(),
            )
        );
        return $actions[$type]??[];
    }
}