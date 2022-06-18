<?php

namespace App\Edus\Place\Domain\Services;

use App\Domain\Services\TableType;
use App\Edus\Place\Domain\Repositories\PlaceRepository as Repository;
use App\Helpers\FieldTypes\Reference;
use App\Helpers\FieldTypes\Number;
use App\Helpers\FieldTypes\Double;
use App\Helpers\FieldTypes\DateTime;
use App\Helpers\Field;

class ListService extends TableType
{

    protected $repository;

    public $name = "place";

    public $headers;

    public $datas;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle()
    {
        $admin = auth()->user();
        $is_test = isset($admin->is_test) ? $admin->is_test : false;
        $this->headers = $this->getHeader();
        $this->datas = $this->repository->getList($admin->punkt_id, $is_test);
        return $this->getData();
    }

    /**
     * Заголовки
     * 
     * @return array<mixed>
     */
    private function getHeader()
    {
        return [
            "club_category_id" => Field::_()->init(new Reference("club-category"))->key("club_category")->onCreate("visible", true)->onUpdate("disabled")->render(),
            "club_subcategory_id" => Field::_()->init(new Reference("club-subcategory"))->link("club_category_id")->key("club_subcategory")->onCreate("visible", true)->onUpdate("disabled")->render(),
            "quantity" => Field::_()->init(new Number())->onCreate("visible", true)->onUpdate("disabled")->min(1)->render(),
            "amount" => Field::_()->init(new Double())->onCreate("visible", true)->onUpdate("disabled")->min(1)->render(),
            "place_type_id" => Field::_()->init(new Reference("place-type"))->key("place_type")->onCreate("visible", true)->onUpdate("disabled")->render(),
            "place_status_id" => Field::_()->init(new Reference("place-status"))->key("place_status")->render(),
            "start_date" => Field::_()->init(new DateTime())->minDate(date("Y-m-d H:i:s"))->onCreate("visible", true)->render(),
            "end_date" => Field::_()->init(new DateTime())->link("start_date")->onCreate("visible", true)->render(),
        ];
    }

}