<?php

namespace App\Mrt\Reception\Domain\Services;

use App\Domain\Services\TableType;
use App\Mrt\Reception\Domain\Repositories\ReceptionRepository as Repository;
use App\Helpers\FieldTypes\Email;
use App\Helpers\FieldTypes\Text;
use App\Helpers\FieldTypes\DateTime;
use App\Helpers\FieldTypes\Boolean;
use App\Helpers\Field;
use Illuminate\Support\Facades\App;
use App\Helpers\Action;

class ListService extends TableType
{
    public $name = "reception";

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
            "password" => Field::_()
                            ->init(new Text())
                            ->onCreate("visible", true)
                            ->onView("invisible")
                            ->minLength(6)
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
    public function action($reception_id = 0)
    {
        return [
            "update" =>  Action::_()
                ->requestType("put")
                ->requestUrl(route('branch-admin.reception.update', ['locale' => App::currentLocale(), 'reception_id' => $reception_id]))
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
                ->requestUrl(route('branch-admin.reception.create', ['locale' => App::currentLocale()]))
                ->type("success")
                ->render(),
        ];
    }
}