<?php

namespace App\Mrt\Suborder\Domain\Services;

use App\Domain\Services\TableType;
use App\Mrt\Suborder\Domain\Repositories\SuborderRepository as Repository;
use App\Helpers\FieldTypes\Number;
use App\Helpers\FieldTypes\Text;
use App\Helpers\FieldTypes\Email;
use App\Helpers\FieldTypes\Date;
use App\Helpers\FieldTypes\PhoneNumber;
use App\Helpers\FieldTypes\Boolean;
use App\Helpers\Field;
use Illuminate\Support\Facades\App;
use App\Helpers\Action;

class ListAllForReceptionService extends TableType
{
    public $name = "suborder";

    protected $repository;

    public $headers;

    public $datas;

    public $actions;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($start_date = "", $end_date = "")
    {
        $user = auth('reception')->user();
        $this->headers = $this->getHeader();
        $this->datas = $this->repository->getAllByDateRange($user->branch_id, $start_date, $end_date);
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
            "iin" => Field::_()
                    ->init(new Number())
                    ->onCreate("visible", true)
                    ->onUpdate("visible")
                    ->minLength(12)
                    ->maxLength(12)
                    ->render(),
            "whithout_iin" => Field::_()
                            ->init(new Boolean())
                            ->onCreate("visible")
                            ->onUpdate("visible")
                            ->render(),
            "full_name" => Field::_()
                            ->init(new Text())
                            ->onCreate("visible", true)
                            ->onUpdate("visible", true)
                            ->maxLength(255)
                            ->render(),
            "phone_number" => Field::_()
                            ->init(new PhoneNumber())
                            ->onCreate("visible", true)
                            ->onUpdate("visible", true)
                            ->minLength(16)
                            ->maxLength(16)
                            ->render(),
            "birthday" => Field::_()
                        ->init(new Date())
                        ->onCreate("visible")
                        ->onUpdate("visible")
                        ->maxLength(255)
                        ->render(),
            "email" => Field::_()
                        ->init(new Email())
                        ->onCreate("visible")
                        ->onUpdate("visible")
                        ->maxLength(255)
                        ->render(),
        ];
    }

    /**
     * действия для каждой строки
     *
     * @param string|int $suborder_id Айди
     *
     * @return array<mixed>
    */
    public function action($suborder_id = 0)
    {
        return [
            "view" =>  Action::_()
                ->requestType("view")
                ->requestUrl(route('reception.suborder.view', ['locale' => App::currentLocale(), 'suborder_id' => $suborder_id]))
                ->type("info")
                ->render(),
        ];
    }

    /**
     * Глобальные действии
     *
     * @return array<mixed>
     */
    private function getAction()
    {
        return [
            "create" =>  Action::_()
                        ->requestType("post")
                        ->requestUrl(route('reception.patient.create', ['locale' => App::currentLocale()]))
                        ->type("success")
                        ->afterResponse("open_result")
                        ->render(),
        ];
    }

}
