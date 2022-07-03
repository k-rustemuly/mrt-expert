<?php

namespace App\Mrt\Suborder\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class Suborder extends Model
{

    public $table = 'suborders';

    protected $guarded = ['id'];

}