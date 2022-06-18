<?php

namespace App\Edus\LegalForm\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class LegalForm extends Model
{

    public $table = 'rb_legal_form';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

}