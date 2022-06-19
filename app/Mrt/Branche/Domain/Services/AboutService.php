<?php

namespace App\Mrt\Branche\Domain\Services;

use App\Domain\Services\BlockType;
use App\Mrt\Branche\Domain\Repositories\BrancheRepository as Repository;
use App\Helpers\Action;
use App\Helpers\Block;
use App\Exceptions\MainException;
use Illuminate\Support\Facades\App;
use App\Helpers\Field;
use App\Helpers\FieldTypes\Text;
use App\Helpers\FieldTypes\Boolean;

class AboutService extends BlockType
{

    protected $repository;

    public $name = "one_branche";

    public $blocks;

    public $actions;

    public $headers;

    public $branche_id;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $branche_id ID 
     */
    public function handle($branche_id = 0)
    {
        $this->branche_id = $branche_id;

        $aboutBranche = $this->repository->getById($branche_id);
        if(empty($aboutBranche)) throw new MainException("You dont have permission or record not found");

        $this->actions = $this->getActions();
        $this->headers = $this->getHeader($aboutBranche);
        $this->blocks = array(
            "main_info" => Block::_()
                        ->values($this->getMainBlock($aboutBranche))
            );
        return $this->getData();
    }

    /** 
     * Главный блок
     * 
     * @param array<mixed> $values Данные для заполнение данных блока
     * 
     * @return array<mixed>
    */
    private function getMainBlock(array $values = array())
    {
        return [
                "punkt" => [
                    "value" => $values["punkt_name"],
                ],
                "name_kk" => [
                    "value" => $values["name_kk"],
                ],
                "name_ru" => [
                    "value" => $values["name_ru"],
                ],
                "is_active" => [
                    "value" => __($values["is_active"] ? "yes" : "no"),
                ]
        ];
    }

    /**
     * Заголовки
     * 
     * @param array $values
     * 
     * @return array<mixed>
     */
    private function getHeader(array $values = array())
    {
        return [
            "edit" => [
                "name_kk" => Field::_()
                            ->init(new Text())
                            ->onUpdate("visible", true)
                            ->maxLength(255)
                            ->value($values["name_kk"])
                            ->render(),
                "name_ru" => Field::_()
                            ->init(new Text())
                            ->onUpdate("visible", true)
                            ->maxLength(255)
                            ->value($values["name_ru"])
                            ->render(),
                "is_active" => Field::_()
                                ->init(new Boolean())
                                ->onUpdate("visible", true)
                                ->value(
                                    [
                                        "id" => $values["is_active"],
                                        "name" => __($values["is_active"] ? "yes" : "no")
                                    ]
                                )
                                ->render(),
            ]
        ];
    }

    /**
     * @param string $type
     * 
     * @return array<mixed>
     */
    private function getActions($type = "default")
    {
        $actions = array(
            "default" => array(
                "edit" => 
                    Action::_()
                    ->requestType("put")
                    ->requestUrl(route('super-admin.branche.save', ['locale' => App::currentLocale(), 'branche_id' => $this->branche_id]))
                    ->type()
                    ->render(),
            )
        );
        return $actions[$type]??[];
    }
}