<?php

namespace App\Edus\Place\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{

    public $table = 'place';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

}