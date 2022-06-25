<?php

namespace App\Mrt\Branch\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{

    public $table = 'company_branchs';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

}