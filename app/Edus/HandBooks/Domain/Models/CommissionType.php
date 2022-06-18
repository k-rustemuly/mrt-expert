<?php

namespace App\Edus\HandBooks\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionType extends Model
{

    protected $table = 'rb_commission_type';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

}