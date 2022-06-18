<?php
namespace App\Edus\Commissions\Domain\Repositories;

use App\Domain\Repositories\Repository;
use App\Edus\Commissions\Domain\Models\Commission as Model;
use Illuminate\Support\Facades\App;

class CommissionRepository extends Repository
{
    protected $model;

    private $language;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->language = App::currentLocale();
    }

    /**
     * Берем список всех комисии
     * 
     * @param string|int $punkt_id Какой пункт
     * @param bool $is_test Тестовый ли аккаунт?
     * 
     * @return array<mixed>
     */
    public function getList($punkt_id, bool $is_test = false)
    {
        $query = $this->join('rb_commission_type', $this->model->table.'.commission_type_id', '=', 'rb_commission_type.id')
        ->select($this->model->table.'.*', 'rb_commission_type.name_'.$this->language.' as commission_type_name')
        ->where($this->model->table.'.is_test', $is_test)
        ->where($this->model->table.'.punkt_id', $punkt_id);
        return $query->get()->all();
    }

    /**
     * Обновляем доступ к системе!
     * В системе должно быть только один председатель комиссии пункта!
     * 
     * @param string|int $id Айди комиссии
     * @param array<mixed> $where допольнительные параметры поиска
     * @param bool $is_access новое значение для обновление
     * 
     * @return bool Обновился ли запись
     */
    public function updateIsAccess($id, array $where, bool $is_access):bool
    {
        if($is_access)
        {
            $others = $this->where($where)->where('id', '!=', $id)->where('commission_type_id', 1)->where('is_access', 1)->get()->first();
            if(!empty($others))
                return false;
        }
        $where["id"] = $id;
        $attributes = array(
            "is_access" => $is_access
        );
        return $this->updateWhere($where,$attributes) > 0;
    }

    /**
     * Проверяет на дупликат председателя комисии в одном пункте с доступом к системе
     * 
     * @param string|int $punkt_id
     * @param bool $is_test
     * 
     * @return bool
     */
    public function isOnceAccessed($punkt_id, bool $is_test = false):bool
    {
            $list = $this->where('punkt_id', $punkt_id)->where('is_test', $is_test)->where('is_access', 1)->where('commission_type_id', 1)->get()->first();
            return empty($list);
        
    }
}