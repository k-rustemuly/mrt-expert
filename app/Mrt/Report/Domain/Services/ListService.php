<?php

namespace App\Mrt\Report\Domain\Services;

use App\Domain\Services\BlockType;
use App\Helpers\Block;

class ListService extends BlockType
{
    public $name = "report";

    public $blocks;

    public function __construct()
    {
    }

    public function handle()
    {
        $this->blocks = array(
            "first" => Block::_()
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
}
