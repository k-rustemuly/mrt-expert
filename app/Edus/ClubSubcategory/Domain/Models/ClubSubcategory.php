<?php

namespace App\Edus\ClubSubcategory\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class ClubSubcategory extends Model
{

    public $table = 'rb_club_subcategory';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

}