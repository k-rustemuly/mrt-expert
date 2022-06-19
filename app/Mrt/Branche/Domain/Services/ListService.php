<?php

namespace App\Mrt\Branche\Domain\Services;

use App\Domain\Services\TableType;
use App\Mrt\Branche\Domain\Repositories\BrancheRepository as Repository;
use App\Helpers\FieldTypes\Reference;
use App\Helpers\FieldTypes\Number;
use App\Helpers\FieldTypes\Text;
use App\Helpers\FieldTypes\Boolean;
use App\Helpers\FieldTypes\DateTime;
use App\Helpers\Field;

class ListService extends TableType
{
    public $name = "branche";

    protected $repository;

    public $headers;

    public $datas;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle()
    {
        $this->headers = $this->getHeader();
        $this->datas = $this->repository->getList();
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
            "punkt_id" => Field::_()
                                ->init(new Reference("punkt"))
                                ->key("punkt")
                                ->onCreate("visible", true)
                                ->render(),
            "name_kk" => Field::_()
                                ->init(new Text())
                                ->onCreate("visible", true)
                                ->onUpdate("visible", true)
                                ->render(),
            "name_ru" => Field::_()
                            ->init(new Text())
                            ->onCreate("visible", true)
                            ->onUpdate("visible", true)
                            ->render(),
            "is_active" => Field::_()
                                ->init(new Boolean())
                                ->onUpdate("visible", true)
                                ->render(),
        ];
    }

}