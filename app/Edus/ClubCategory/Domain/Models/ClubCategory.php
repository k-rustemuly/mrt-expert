<?php

namespace App\Edus\ClubCategory\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class ClubCategory extends Model
{

    public $table = 'rb_club_category';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

}