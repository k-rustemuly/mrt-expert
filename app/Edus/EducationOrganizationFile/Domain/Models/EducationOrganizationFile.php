<?php

namespace App\Edus\EducationOrganizationFile\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class EducationOrganizationFile extends Model
{

    public $table = 'education_organization_file';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

}