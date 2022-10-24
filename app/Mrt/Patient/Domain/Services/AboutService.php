<?php

namespace App\Mrt\Patient\Domain\Services;

use App\Domain\Services\BlockType;
use App\Mrt\Patient\Domain\Repositories\PatientRepository as Repository;
use App\Mrt\Subservice\Domain\Repositories\SubserviceRepository;
use App\Helpers\Action;
use App\Helpers\Block;
use App\Exceptions\MainException;
use Illuminate\Support\Facades\App;
use App\Helpers\Field;
use App\Helpers\FieldTypes\Text;
use App\Helpers\FieldTypes\Email;
use App\Helpers\FieldTypes\Date;
use App\Helpers\FieldTypes\PhoneNumber;

class AboutService extends BlockType
{

    protected $repository;

    protected $subserviceRepository;

    public $name = "one_patient";

    public $blocks;

    public $actions;

    public $headers;

    public $patient_id;

    public function __construct(Repository $repository, SubserviceRepository $subserviceRepository)
    {
        $this->repository = $repository;
        $this->subserviceRepository = $subserviceRepository;
    }

    /**
     * @param string $patient_id ID
     */
    public function handle($patient_id = 0)
    {
        $this->patient_id = $patient_id;

        $aboutPatient = $this->repository->getById($patient_id);
        if(empty($aboutPatient)) throw new MainException("You dont have permission or record not found");

        $this->actions = $this->getActions();
        $this->headers = $this->getHeader($aboutPatient);
        $this->blocks = array(
            "main_info" => Block::_()
                        // ->position("left")
                        ->values($this->getMainBlock($aboutPatient))
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
                "full_name" => [
                    "value" => $values["full_name"],
                ],
                "email" => [
                    "value" => $values["email"],
                ],
                "phone_number" => [
                    "value" => $values["phone_number"],
                ],
                "birthday" => [
                    "value" => $values["birthday"],
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
                "full_name" => Field::_()
                            ->init(new Text())
                            ->onUpdate("visible", true)
                            ->maxLength(255)
                            ->value($values["full_name"])
                            ->render(),
                "iin" => Field::_()
                            ->init(new Text())
                            ->onUpdate("visible", true)
                            ->minLength(12)
                            ->maxLength(12)
                            ->value($values["iin"])
                            ->render(),
                "email" => Field::_()
                            ->init(new Email())
                            ->onUpdate("visible")
                            ->value($values["email"])
                            ->render(),
                "birthday" => Field::_()
                            ->init(new Date())
                            ->onUpdate("visible")
                            ->value($values["birthday"])
                            ->render(),
                "phone_number" => Field::_()
                            ->init(new PhoneNumber())
                            ->onUpdate("visible", true)
                            ->value($values["phone_number"])
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
                    ->requestUrl(route('reception.patient.update', ['locale' => App::currentLocale(), 'patient_id' => $this->patient_id]))
                    ->render(),
            )
        );
        return $actions[$type]??[];
    }

}
