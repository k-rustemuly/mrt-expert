<?php

namespace App\Edus\Upload\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{

    public $table = 'upload';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

}