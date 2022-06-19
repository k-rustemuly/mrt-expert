<?php
namespace App\Domain\Repositories;

abstract class Repository implements RepositoryInterface
{
    public function __call($method, $arguments)
    {
        return $this->model->{$method}(...$arguments);
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return tap($this->getById($id), function ($record) use ($attributes) {
            $record->update($attributes);
        });
    }

    public function updateWhere(array $where, array $attributes)
    {
        return $this->where($where)->update($attributes);
    }

    public function delete($id)
    {
        return $this->getById($id)->delete();
    }

    public function getByBinAndIin($bin, $iin)
    {
        return $this->model->where('iin', $iin)->where('bin', $bin)->first();
    }

    public function deleteWhere(array $where)
    {
        return $this->where($where)->delete();
    }

    public function getByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }
}