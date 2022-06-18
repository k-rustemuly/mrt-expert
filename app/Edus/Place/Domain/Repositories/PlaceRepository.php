<?php
namespace App\Edus\Place\Domain\Repositories;

use App\Domain\Repositories\Repository;
use App\Edus\Place\Domain\Models\Place as Model;
use Illuminate\Support\Facades\App;
use App\Edus\PlaceStatus\Domain\Models\PlaceStatus;

class PlaceRepository extends Repository
{
    protected $model;

    private $language;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->language = App::currentLocale();
    }

    /**
     * Список мест по одному пункту!
     * 
     * @param string|int $punkt_id
     * @param bool $is_test
     * 
     * @return array<mixed>
     */
    public function getList($punkt_id, bool $is_test = false):array
    {
        $query = $this->join('rb_club_category', $this->model->table.'.club_category_id', '=', 'rb_club_category.id')
        ->join('rb_club_subcategory', $this->model->table.'.club_subcategory_id', '=', 'rb_club_subcategory.id')
        ->join('rb_place_type', $this->model->table.'.place_type_id', '=', 'rb_place_type.id')
        ->join('rb_place_status', $this->model->table.'.place_status_id', '=', 'rb_place_status.id')
        ->select($this->model->table.'.*',
            'rb_club_category.name_'.$this->language.' as club_category_name',
            'rb_club_subcategory.name_'.$this->language.' as club_subcategory_name',
            'rb_place_type.name_'.$this->language.' as place_type_name',
            'rb_place_status.name_'.$this->language.' as place_status_name',
            'rb_place_status.color as place_status_color')
        ->where($this->model->table.'.is_test', $is_test)
        ->where($this->model->table.'.punkt_id', $punkt_id);
        return $query->get()->all();
    }

    /**
     * Список мест по одному пункту для организации
     * 
     * @param string|int $punkt_id
     * @param bool $is_test
     * 
     * @return array<mixed>
     */
    public function getListForOrg($punkt_id, bool $is_test = false):array
    {
        $query = $this->join('rb_club_category', $this->model->table.'.club_category_id', '=', 'rb_club_category.id')
        ->join('rb_club_subcategory', $this->model->table.'.club_subcategory_id', '=', 'rb_club_subcategory.id')
        ->join('rb_place_type', $this->model->table.'.place_type_id', '=', 'rb_place_type.id')
        ->join('rb_place_status', $this->model->table.'.place_status_id', '=', 'rb_place_status.id')
        ->select($this->model->table.'.*',
            'rb_club_category.name_'.$this->language.' as club_category_name',
            'rb_club_subcategory.name_'.$this->language.' as club_subcategory_name',
            'rb_place_type.name_'.$this->language.' as place_type_name',
            'rb_place_status.name_'.$this->language.' as place_status_name',
            'rb_place_status.color as place_status_color')
        ->where($this->model->table.'.is_test', $is_test)
        ->where($this->model->table.'.punkt_id', $punkt_id)
        ->where($this->model->table.'.place_status_id', '!=', PlaceStatus::DRAFT);
        return $query->get()->all();
    }

    /**
     * Информация по одной записи
     * 
     * @param string|int $id
     * @param string $punkt_id
     * 
     * @return array<mixed>
     */
    public function getOne($id, $punkt_id = 0)
    {
        $query = $this->join('rb_club_category', $this->model->table.'.club_category_id', '=', 'rb_club_category.id')
        ->join('rb_club_subcategory', $this->model->table.'.club_subcategory_id', '=', 'rb_club_subcategory.id')
        ->join('rb_place_type', $this->model->table.'.place_type_id', '=', 'rb_place_type.id')
        ->join('rb_punkt', $this->model->table.'.punkt_id', '=', 'rb_punkt.id')
        ->join('rb_place_status', $this->model->table.'.place_status_id', '=', 'rb_place_status.id')
        ->join('education_department', $this->model->table.'.author_id', '=', 'education_department.id')
        ->select($this->model->table.'.*',
            'rb_club_category.name_'.$this->language.' as club_category_name',
            'rb_club_subcategory.name_'.$this->language.' as club_subcategory_name',
            'rb_punkt.name_'.$this->language.' as punkt_name',
            'rb_place_type.name_'.$this->language.' as place_type_name',
            'rb_place_status.name_'.$this->language.' as place_status_name',
            'rb_place_status.color as place_status_color',
            'education_department.full_name as author_name')
        ->where($this->model->table.'.id', $id);
        if($punkt_id > 0) $query->where($this->model->table.'.punkt_id', $punkt_id);
        $result = $query->first();
        return $result ? $result->toArray() : [];
    }

}