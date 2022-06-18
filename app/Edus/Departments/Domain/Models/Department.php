<?php

namespace App\Edus\Departments\Domain\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Department extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'education_department';

    protected $guard = "department";

    protected $guarded = ['id'];

    protected $hidden = ['last_visit', 'created_at', 'updated_at'];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            "type" => "department",
            // "user" => $this
        ];
    }

    public function generateAuthToken()
    {
        return \JWTAuth::fromUser($this);
    }
}