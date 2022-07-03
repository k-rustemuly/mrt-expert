<?php
namespace App\Domain\Repositories;

abstract class ReferenceRepository
{
    
    public function __call($method, $arguments)
    {
        return $this->model->{$method}(...$arguments);
    }

    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function delete($id)
    {
        return $this->getById($id)->delete();
    }

    public function getAll($is_multilevel = false)
    {
        $query = $this->select( 'id', 'name_'.$this->language.' as name');
        if($is_multilevel) $query = $this->select('id', 'name_'.$this->language.' as name', 'parent_id', 'is_have_child');
        return $query->get()->all();
    }

    public function getAllByParentId($parent_id = 0)
    {
        $query = $this->select( 'id', 'name_'.$this->language.' as name')
        ->where('parent_id', $parent_id);
        return $query->get()->all();
    }

    public function getInList($list = array())
    {
        $query = $this->select('id', 'name_'.$this->language.' as name')
            ->whereIn('id', $list);
        return $query->get()->all();
    }

}