<?php

namespace App\Mrt\Admin\Domain\Services;

use App\Domain\Services\TableType;
use App\Mrt\Admin\Domain\Repositories\AdminRepository as Repository;
use App\Helpers\FieldTypes\Email;
use App\Helpers\FieldTypes\Text;
use App\Helpers\FieldTypes\DateTime;
use App\Helpers\FieldTypes\Boolean;
use App\Helpers\Field;
use Illuminate\Support\Facades\App;
use App\Helpers\Action;

class ListService extends TableType
{
    public $name = "admin";

    protected $repository;

    public $headers;

    public $datas;

    public $actions;

    public $branch_id;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($branch_id = 0)
    {
        $this->branch_id = $branch_id;
        $this->headers = $this->getHeader();
        $this->datas = $this->repository->getList($branch_id);
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

    /** 
     * действия для каждой строки
     * 
     * @param string|int $branch_id Айди 
     * 
     * @return array<mixed>
    */
    public function action($admin_id = 0)
    {
        return [
            // "view" =>  Action::_()
            //     ->requestType("get")
            //     ->requestUrl(route('super-admin.branch.admin.view', ['locale' => App::currentLocale(), 'branch_id' => $this->branch_id, 'admin_id' => $admin_id]))
            //     ->type("info")
            //     ->render(),
            "update" =>  Action::_()
                ->requestType("put")
                ->requestUrl(route('super-admin.branch.admin.update', ['locale' => App::currentLocale(), 'branch_id' => $this->branch_id, 'admin_id' => $admin_id]))
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
                ->requestUrl(route('super-admin.branch.admin.create', ['locale' => App::currentLocale(), 'branch_id' => $this->branch_id]))
                ->type("success")
                ->render(),
        ];
    }

}