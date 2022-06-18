<?php

namespace App\Edus\DepartmentalAffiliation\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentalAffiliation extends Model
{

    public $table = 'rb_departmental_affiliation';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

}