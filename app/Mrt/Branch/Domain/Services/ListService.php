<?php

namespace App\Mrt\Branch\Domain\Services;

use App\Domain\Services\TableType;
use App\Mrt\Branch\Domain\Repositories\BranchRepository as Repository;
use App\Helpers\FieldTypes\Reference;
use App\Helpers\FieldTypes\Text;
use App\Helpers\FieldTypes\Boolean;
use App\Helpers\Field;
use Illuminate\Support\Facades\App;
use App\Helpers\Action;


class ListService extends TableType
{
    public $name = "branch";

    protected $repository;

    public $headers;

    public $datas;

    public $actions;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle()
    {
        $this->headers = $this->getHeader();
        $this->datas = $this->repository->getList();
        $this->actions = $this->getAction();
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
                                ->maxLength(255)
                                ->render(),
            "name_ru" => Field::_()
                            ->init(new Text())
                            ->onCreate("visible", true)
                            ->onUpdate("visible", true)
                            ->maxLength(255)
                            ->render(),
            "is_active" => Field::_()
                                ->init(new Boolean())
                                ->onUpdate("visible", true)
                                ->render(),
        ];
    }

    /**
     * действия для каждой строки
     *
     * @param array|object $object
     *
     * @return array<mixed>
    */
    public function action($object = null)
    {
        return [
            "view" =>  Action::_()
                ->requestType("put")
                ->requestUrl(route('super-admin.branch.view', ['locale' => App::currentLocale(), 'branch_id' => $object["id"]]))
                ->type("info")
                ->render(),
        ];
    }

    /**
     * Глабольные действии
     *
     * @return array<mixed>
     */
    private function getAction()
    {
        return [
            "create" =>  Action::_()
                ->requestType("post")
                ->requestUrl(route('super-admin.branch.create', ['locale' => App::currentLocale()]))
                ->type("success")
                ->render(),
        ];
    }

}
