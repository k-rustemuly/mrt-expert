<?php

namespace App\Edus\Organization\Domain\Services;

use App\Domain\Services\TableType;
use App\Edus\Organization\Domain\Repositories\OrganizationRepository as Repository;
use App\Helpers\Field;
use App\Helpers\FieldTypes\Reference;
use App\Helpers\FieldTypes\Number;
use App\Helpers\FieldTypes\Text;

class ListService extends TableType
{

    protected $repository;

    public $name = "organization";

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
            "bin" => Field::_()->init(new Number())->render(),
            "name" => Field::_()->init(new Text())->render(),
            "director_fullname" => Field::_()->init(new Text())->render(),
            "access_status_id" => Field::_()->init(new Reference("access-status"))->key("access_status")->render(),
        ];
    }

}