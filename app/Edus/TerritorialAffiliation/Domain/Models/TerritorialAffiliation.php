<?php

namespace App\Edus\TerritorialAffiliation\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class TerritorialAffiliation extends Model
{

    public $table = 'rb_territorial_affiliation';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

}