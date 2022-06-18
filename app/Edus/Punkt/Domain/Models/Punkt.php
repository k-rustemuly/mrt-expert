<?php

namespace App\Edus\Punkt\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class Punkt extends Model
{

    public $table = 'rb_punkt';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

}