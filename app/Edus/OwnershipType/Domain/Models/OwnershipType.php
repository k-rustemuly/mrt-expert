<?php

namespace App\Edus\OwnershipType\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class OwnershipType extends Model
{

    public $table = 'rb_ownership_type';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

}