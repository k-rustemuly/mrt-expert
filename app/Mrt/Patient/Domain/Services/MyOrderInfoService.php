<?php

namespace App\Mrt\Patient\Domain\Services;

use App\Domain\Services\BlockType;
use App\Mrt\Order\Domain\Repositories\OrderRepository as Repository;
use App\Mrt\Subservice\Domain\Repositories\SubserviceRepository;
use App\Helpers\Block;
use App\Exceptions\MainException;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;

class MyOrderInfoService extends BlockType
{

    protected $repository;

    protected $subserviceRepository;

    public $name = "my_order";

    public $blocks;

    public $actions;

    public $headers;

    public function __construct(Repository $repository, SubserviceRepository $subserviceRepository)
    {
        $this->repository = $repository;
        $this->subserviceRepository = $subserviceRepository;
    }

    /**
     * @param string $patient_id ID 
     */
    public function handle()
    {
        $user = auth('patient')->user();
        $user_id = $user->id;
        $aboutOrder = $this->repository->getByLoginId($user_id);
        if(empty($aboutOrder)) throw new MainException("You dont have permission or record not found");

        $this->blocks = array(
            "main_info" => Block::_()
                        ->values($this->getMainBlock($aboutOrder))
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
                "iin" => [
                    "value" => $values["iin"],
                ],
                "patient_name" => [
                    "value" => $values["patient_name"],
                ],
                "email" => [
                    "value" => $values["email"],
                ],
                "phone_number" => [
                    "value" => $values["phone_number"],
                ],
                "status" => [
                    "value" => $values["status_name"],
                    "color" => $values["status_color"],
                ],
                "created_at" => [
                    "value" => Carbon::parse($values["created_at"])->locale(App::currentLocale())->timezone('Asia/Aqtau')->isoFormat('LLLL'),
                ],
                "updated_at" => [
                    "value" =>  Carbon::parse($values["updated_at"])->locale(App::currentLocale())->timezone('Asia/Aqtau')->isoFormat('LLLL'),
                ]
        ];
    }
}