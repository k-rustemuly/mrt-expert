<?php

namespace App\Mrt\Patient\Domain\Services;

use App\Domain\Services\BlockType;
use App\Mrt\Order\Domain\Repositories\OrderRepository as Repository;
use App\Mrt\Suborder\Domain\Repositories\SuborderRepository;
use App\Helpers\Block;
use App\Exceptions\MainException;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;

class MyOrderInfoService extends BlockType
{

    protected $repository;

    protected $suborderRepository;

    public $name = "my_order";

    public $blocks;

    public $actions;

    public $headers;

    public function __construct(Repository $repository, SuborderRepository $suborderRepository)
    {
        $this->repository = $repository;
        $this->suborderRepository = $suborderRepository;
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
        $suborders = $this->suborderRepository->getAllByOrderIdPatient($aboutOrder["id"]);
        for($i=0; $i<count($suborders); $i++)
        {
            $aboutSuborder = $suborders[$i]->toArray();
            $this->blocks["suborder_".$i] = Block::_()
                                            ->name(__($this->name.".suborder", ['number' => $i+1]))
                                            ->values($this->getSuborderBlock($aboutSuborder));
        }
        return $this->getData();
    }

    /** 
     * Подзаказы блок
     * 
     * @param array<mixed> $values Данные для заполнение данных блока
     * 
     * @return array<mixed>
    */
    private function getSuborderBlock(array $values = array())
    {
        return [
                "service_name" => [
                    "name" => __($this->name.".service_name"),
                    "value" => $values["service_name"],
                ],
                "subservice_name" => [
                    "name" => __($this->name.".subservice_name"),
                    "value" => $values["subservice_name"],
                ],
                "status_name" => [
                    "name" => __($this->name.".status_name"),
                    "value" => $values["status_name"],
                    "color" => $values["status_color"],
                ],
                "appointment_date" => [
                    "name" => __($this->name.".appointment_date"),
                    "value" => Carbon::parse($values["appointment_date"])->locale(App::currentLocale())->timezone('Asia/Aqtau')->isoFormat('LLLL'),
                ]
        ];
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
                "status" => [
                    "value" => $values["status_name"],
                    "color" => $values["status_color"],
                ],
                "created_at" => [
                    "value" => Carbon::parse($values["created_at"])->locale(App::currentLocale())->timezone('Asia/Aqtau')->isoFormat('LLLL'),
                ]
        ];
    }
}