<?php

namespace App\Mrt\Patient\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{

    public $table = 'patient';

    protected $guarded = ['id'];

    protected $hidden = ['password', 'created_at', 'updated_at'];
}