<?php

namespace App\Edus\EducationOrganizationFileType\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class EducationOrganizationFileType extends Model
{

    public $table = 'rb_education_organization_file_type';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

}