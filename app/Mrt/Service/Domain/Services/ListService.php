<?php

namespace App\Mrt\Service\Domain\Services;

use App\Domain\Services\TableType;
use App\Mrt\Service\Domain\Repositories\BranchSubServiceRepository as Repository;
use App\Helpers\FieldTypes\Reference;
use App\Helpers\FieldTypes\Text;
use App\Helpers\Field;
use Illuminate\Support\Facades\App;
use App\Helpers\Action;

class ListService extends TableType
{
    public $name = "service";

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
        $user = auth('branch_admin')->user();
        $this->headers = $this->getHeader();
        $this->datas = $this->repository->getList($user->branch_id);
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
            "subservice_id" => Field::_()
                            ->init(new Reference("subservice"))
                            ->onUpdate("visible", true)
                            ->onView("invisible")
                            ->render(),
            "subservice_name" => Field::_()
                            ->init(new Text())
                            ->render()

        ];
    }

    /** 
     * действия для каждой строки
     * 
     * @param string|int $service_id Айди 
     * 
     * @return array<mixed>
    */
    public function action($service_id = 0)
    {
        return [
            "delete" =>  Action::_()
                ->requestType("delete")
                ->requestUrl(route('branch-admin.service.delete', ['locale' => App::currentLocale(), 'service_id' => $service_id]))
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
                ->requestUrl(route('branch-admin.service.create', ['locale' => App::currentLocale()]))
                ->type("success")
                ->render(),
        ];
    }

}