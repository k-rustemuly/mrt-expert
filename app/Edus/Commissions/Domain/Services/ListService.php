<?php

namespace App\Edus\Commissions\Domain\Services;

use App\Domain\Services\TableType;
use App\Edus\Commissions\Domain\Repositories\CommissionRepository as Repository;
use App\Helpers\FieldTypes\Reference;
use App\Helpers\FieldTypes\Number;
use App\Helpers\FieldTypes\Text;
use App\Helpers\FieldTypes\Boolean;
use App\Helpers\FieldTypes\DateTime;
use App\Helpers\Field;

class ListService extends TableType
{
    public $name = "commision";

    protected $repository;

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
            "commission_type_id" => Field::_()->init(new Reference("commission-type"))->key("commission_type")->onCreate("invisible")->onUpdate("invisible")->render(),
            "iin" => Field::_()->init(new Number())->onCreate("visible", true)->onUpdate("disabled")->minLength(12)->maxLength(12)->render(),
            "full_name" => Field::_()->init(new Text())->onCreate("visible", true)->onUpdate("disabled")->render(),
            "is_access" => Field::_()->init(new Boolean())->onUpdate("visible", true)->render(),
            "last_visit" => Field::_()->init(new DateTime())->render(),
        ];
    }

}