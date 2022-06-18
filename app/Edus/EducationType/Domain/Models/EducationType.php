<?php

namespace App\Edus\EducationType\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class EducationType extends Model
{

    public $table = 'rb_education_type';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

}