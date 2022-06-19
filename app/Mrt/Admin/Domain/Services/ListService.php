<?php

namespace App\Mrt\Admin\Domain\Services;

use App\Domain\Services\TableType;
use App\Mrt\Admin\Domain\Repositories\AdminRepository as Repository;
use App\Helpers\FieldTypes\Email;
use App\Helpers\FieldTypes\Text;
use App\Helpers\FieldTypes\DateTime;
use App\Helpers\FieldTypes\Boolean;
use App\Helpers\Field;

class ListService extends TableType
{
    public $name = "admin";

    protected $repository;

    public $headers;

    public $datas;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($branche_id = 0)
    {
        $this->headers = $this->getHeader();
        $this->datas = $this->repository->getList($branche_id);
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
            "full_name" => Field::_()
                                ->init(new Text())
                                ->onCreate("visible", true)
                                ->onUpdate("visible", true)
                                ->maxLength(255)
                                ->render(),
            "email" => Field::_()
                            ->init(new Email())
                            ->onCreate("visible", true)
                            ->maxLength(255)
                            ->render(),
            "is_active" => Field::_()
                            ->init(new Boolean())
                            ->onUpdate("visible", true)
                            ->render(),
            "last_visit" => Field::_()
                                ->init(new DateTime())
                                ->render(),
        ];
    }

}