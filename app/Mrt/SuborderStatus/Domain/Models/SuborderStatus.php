<?php

namespace App\Mrt\SuborderStatus\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class SuborderStatus extends Model
{

    /**
     * @var string Создано
     */
    const CREATED = '1';

    /**
     * @var string В обработке
     */
    const ONPROGRESS = '2';

    public $table = 'rb_suborder_status';

    protected $guarded = ['id'];

}