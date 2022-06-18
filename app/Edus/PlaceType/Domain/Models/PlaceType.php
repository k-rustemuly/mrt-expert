<?php

namespace App\Edus\PlaceType\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class PlaceType extends Model
{

    public $table = 'rb_place_type';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

}