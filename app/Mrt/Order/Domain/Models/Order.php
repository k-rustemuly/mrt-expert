<?php

namespace App\Mrt\Order\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    public $table = 'orders';

    protected $guarded = ['id'];

}