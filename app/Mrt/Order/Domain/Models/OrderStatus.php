<?php

namespace App\Mrt\Order\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{

    /**
     * @var string Черновик
     */
    const DRAFF = '1';

    /**
     * @var string Зарегистрирован
     */
    const REGISTERED = '2';

    /**
     * @var string Завершен
     */
    const COMPLETED = '3';

    public $table = 'orders';

    protected $guarded = ['id'];

}
