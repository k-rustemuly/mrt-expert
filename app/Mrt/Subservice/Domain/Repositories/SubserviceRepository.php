<?php
namespace App\Mrt\Subservice\Domain\Repositories;

use App\Domain\Repositories\ReferenceRepository;
use App\Mrt\Subservice\Domain\Models\Subservice as Model;
use Illuminate\Support\Facades\App;
use App\Mrt\Service\Domain\Repositories\ServiceRepository;

class SubserviceRepository extends ReferenceRepository
{
    protected $model;

    protected $serviceRepository;

    public $language;

    public function __construct(Model $model, ServiceRepository $serviceRepository)
    {
        $this->model = $model;
        $this->serviceRepository = $serviceRepository;
        $this->language = App::currentLocale();
    }

    public function getAll($is_multilevel = false)
    {
        $services = $this->serviceRepository->getAll();
        for($i=0; $i<count($services); $i++)
        {
            $id = $services[$i]["id"];
            $services[$i]["children"] = $this->getAllByServiceId($id);
        }
        return $services;
    }

    public function getAllByServiceId($service_id = 0)
    {
        $query = $this->select( 'id', 'name_'.$this->language.' as name')
        ->where('service_id', $service_id);
        return $query->get()->all();
    }
}