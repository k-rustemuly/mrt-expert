<?php
namespace App\Domain\Repositories;
interface RepositoryInterface
{
    public function getAll();
    public function getById($id);
    public function create(array $attributes);
    public function update($id, array $attributes);
    public function updateWhere(array $where, array $attributes);
    public function delete($id);
    public function getByBinAndIin($bin, $iin);
}