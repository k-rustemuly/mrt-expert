<?php

namespace App\Edus\Commissions\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{

    public $table = 'commission';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

}