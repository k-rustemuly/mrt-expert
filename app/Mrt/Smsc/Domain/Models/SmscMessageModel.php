<?php

namespace App\Mrt\Smsc\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class SmscMessageModel extends Model
{

    public $table = 'smsc_message_status';

    protected $guarded = ['id'];

}
