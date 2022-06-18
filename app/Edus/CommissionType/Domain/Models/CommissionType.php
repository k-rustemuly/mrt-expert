<?php

namespace App\Edus\CommissionType\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionType extends Model
{

    public $table = 'rb_commission_type';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

}