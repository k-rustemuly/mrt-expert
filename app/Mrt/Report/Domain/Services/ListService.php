<?php

namespace App\Mrt\Report\Domain\Services;

use App\Domain\Services\BlockType;
use App\Helpers\Action;
use Illuminate\Support\Facades\App;
use App\Helpers\Field;
use App\Helpers\FieldTypes\DateTime;
use App\Helpers\Block;

class ListService extends BlockType
{
    public $name = "report";

    public $blocks;

    public $prefix = "reception";

    public function __construct()
    {
    }

    public function handle()
    {
        if(auth('assistant')->user()) $this->prefix = "assistant";
        $this->blocks = array(
            "first" => Block::_()
                    ->action($this->getActions("first"))
                    ->values($this->getFirst()),
            );
        return $this->getData();
    }

    private function getFirst()
    {
        return [
            "name" => [
                "value" => __($this->name.".first.name"),
            ],
            "description" => [
                "value" => __($this->name.".first.description"),
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
            "first" => [
                "first_generate" => Action::_()
                                        ->requestType("post")
                                        ->requestUrl(route($this->prefix.'.report.first', ['locale' => App::currentLocale()]))
                                        ->render(),
            ],
        );
        return $actions[$type]??[];
    }


    /**
     * Заголовки
     *
     * @param array $values
     *
     * @return array<mixed>
     */
    private function getHeader()
    {
        return [
            "first_generate" => [
                "from_date" => Field::_()
                                ->init(new DateTime())
                                ->onUpdate("visible", true)
                                ->value(date("Y-m-d H:i"))
                                ->render(),
                "to_date" => Field::_()
                                ->init(new DateTime())
                                ->onUpdate("visible", true)
                                ->value(date("Y-m-d H:i"))
                                ->render(),
            ]
        ];
    }
}
