<?php

namespace App\Edus\Organization\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{

    public $table = 'organization';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

}