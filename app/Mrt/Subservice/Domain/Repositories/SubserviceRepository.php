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

    public function getAllByBranch($branch_id){
        $query = $this->join('branch_subservice', $this->model->table.'.id', '=', 'branch_subservice.subservice_id')
        ->select('rb_subservice.name_'.$this->language.' as name', $this->model->table.'.id', $this->model->table.'.service_id')
        ->where('branch_subservice.branch_id', $branch_id);
        return (string) $query;
        $subservices = $query->get()->all();
        $service_ids = [];
        $result = [];
        for($i=0; $i<count($subservices); $i++)
        {
            $service_id = $subservices[$i]["service_id"];
            if(!array_key_exists($service_id, $service_ids))
            {
                $service_ids[$service_id] = count($service_ids);
                $result[$service_ids[$service_id]] = $this->serviceRepository->getById($service_id);
            }
            $k = $service_ids[$service_id];
            $result[$k]["children"][] = $subservices[$i];
        }
    }
}