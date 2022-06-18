<?php

namespace App\Edus\PlaceStatus\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class PlaceStatus extends Model
{

    public const DRAFT = 1;
    public const PUBLISHED = 2;

    public $table = 'rb_place_status';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

}