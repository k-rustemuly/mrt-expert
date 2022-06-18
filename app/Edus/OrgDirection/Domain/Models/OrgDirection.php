<?php

namespace App\Edus\OrgDirection\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class OrgDirection extends Model
{

    public $table = 'rb_org_direction';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

}