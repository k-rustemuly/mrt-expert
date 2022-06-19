<?php

namespace App\Mrt\Branche\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class Branche extends Model
{

    public $table = 'company_branches';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

}