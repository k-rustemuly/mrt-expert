<?php
namespace App\Edus\EducationOrganizationFile\Domain\Repositories;

use App\Domain\Repositories\ReferenceRepository;
use App\Edus\EducationOrganizationFile\Domain\Models\EducationOrganizationFile as Model;

class EducationOrganizationFileRepository extends ReferenceRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Список файлов организации по айди типа файла и айди организации!
     * 
     * @param string|int $organization_id
     * @param string|int $file_type_id
     * 
     * @return array<mixed>
     */
    public function getList($organization_id, $file_type_id):array
    {
        $query = $this->join('upload', $this->model->table.'.upload_id', '=', 'upload.id')
        ->select($this->model->table.'.*',
            'upload.file_url',
            'upload.file_size',
            'upload.file_extension')
        ->where($this->model->table.'.organization_id', $organization_id)
        ->where($this->model->table.'.file_type_id', $file_type_id);
        return $query->get()->all();
    }

    public function getNextOrder($organization_id, $file_type_id):int
    {
        $query = $this->select('file_order')
        ->where('organization_id', $organization_id)
        ->where('file_type_id', $file_type_id)
        ->orderByDesc('file_order')
        ->limit(1);
        $result = $query->first();
        if($result) return $result->file_order+1;
        return 1; 
    }

    public function getInfoFile($organization_id, $file_id)
    {
        $query = $this->join('upload', $this->model->table.'.upload_id', '=', 'upload.id')
        ->select($this->model->table.'.*',
            'upload.file_path')
        ->where($this->model->table.'.organization_id', $organization_id)
        ->where($this->model->table.'.id', $file_id);
        return $query->first();
    }
}