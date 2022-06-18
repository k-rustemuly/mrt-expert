<?php

namespace App\Edus\LocalityPart\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class LocalityPart extends Model
{

    public $table = 'rb_locality_part';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

}