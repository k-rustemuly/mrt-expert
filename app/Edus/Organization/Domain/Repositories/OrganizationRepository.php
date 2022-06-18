<?php
namespace App\Edus\Organization\Domain\Repositories;

use App\Domain\Repositories\Repository;
use App\Edus\Organization\Domain\Models\Organization as Model;
use Illuminate\Support\Facades\App;
use App\Edus\AccessStatus\Domain\Models\AccessStatus;

class OrganizationRepository extends Repository
{
    protected $model;

    private $language;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->language = App::currentLocale();
    }

    /**
     * Список организации по одному пункту!
     * 
     * @param string|int $punkt_id
     * @param bool $is_test
     * 
     * @return array<mixed>
     */
    public function getList($punkt_id, bool $is_test = false):array
    {
        $query = $this->join('rb_access_status', $this->model->table.'.access_status_id', '=', 'rb_access_status.id')
        ->select($this->model->table.'.id',
            $this->model->table.'.bin',
            $this->model->table.'.name_'.$this->language.' as name',
            $this->model->table.'.full_name_'.$this->language.' as full_name',
            $this->model->table.'.director_fullname',
            $this->model->table.'.access_status_id',
            'rb_access_status.name_'.$this->language.' as access_status_name',
            'rb_access_status.color as access_status_color')
        ->where($this->model->table.'.is_test', $is_test)
        ->where($this->model->table.'.access_status_id', '!=', AccessStatus::HAS_NO_RIGHT)
        ->where($this->model->table.'.punkt_id', $punkt_id);
        return $query->get()->all();
    }

    /**
     * Об одной организации по одному пункту и айди!
     * 
     * @param string|int $organization_id
     * @param string|int $punkt_id
     * 
     * @return array<mixed>
     */
    public function getOne($organization_id, $punkt_id):array
    {
        $query = $this->join('rb_access_status', $this->model->table.'.access_status_id', '=', 'rb_access_status.id')
        ->select($this->model->table.'.id',
            $this->model->table.'.bin',
            $this->model->table.'.name_kk',
            $this->model->table.'.name_ru',
            $this->model->table.'.full_name_kk',
            $this->model->table.'.full_name_ru',
            $this->model->table.'.oked_code',
            $this->model->table.'.krp_code',
            $this->model->table.'.kato_code',
            $this->model->table.'.director_fullname',
            $this->model->table.'.access_status_id',
            'rb_access_status.name_'.$this->language.' as access_status_name',
            'rb_access_status.color as access_status_color')
        ->where($this->model->table.'.id', $organization_id)
        ->where($this->model->table.'.punkt_id', $punkt_id);
        $result = $query->first();
        return $result ? $result->toArray() : [];
    }

    /**
     * Об одной организации по бину
     * 
     * @param string|int $bin
     * 
     * @return object|null
     */
    public function getByBin($bin)
    {
        $query = $this->select('*')
        ->where('bin', $bin);
        return $query->first();
    }

    public function getById($id){
        $query = $this->join('rb_access_status', $this->model->table.'.access_status_id', '=', 'rb_access_status.id')
        ->join('rb_ownership_type', $this->model->table.'.ownership_type_id', '=', 'rb_ownership_type.id')
        ->join('rb_departmental_affiliation', $this->model->table.'.departmental_affiliation_id', '=', 'rb_departmental_affiliation.id')
        ->join('rb_territorial_affiliation', $this->model->table.'.territorial_affiliation_id', '=', 'rb_territorial_affiliation.id')
        ->join('rb_legal_form', $this->model->table.'.legal_form_id', '=', 'rb_legal_form.id')
        ->join('rb_locality_part', $this->model->table.'.locality_part_id', '=', 'rb_locality_part.id')
        ->join('rb_education_type', $this->model->table.'.education_type_id', '=', 'rb_education_type.id')
        ->select($this->model->table.'.*',
            'rb_ownership_type.name_'.$this->language.' as ownership_type_name',
            'rb_legal_form.name_'.$this->language.' as legal_form_name',
            'rb_locality_part.name_'.$this->language.' as locality_part_name',
            'rb_territorial_affiliation.name_'.$this->language.' as territorial_affiliation_name',
            'rb_departmental_affiliation.name_'.$this->language.' as departmental_affiliation_name',
            'rb_education_type.name_'.$this->language.' as education_type_name',
            'rb_access_status.name_'.$this->language.' as access_status_name',
            'rb_access_status.color as access_status_color')
        ->where($this->model->table.'.id', $id);
        $result = $query->first();
        return $result ? $result->toArray() : [];
    }
}