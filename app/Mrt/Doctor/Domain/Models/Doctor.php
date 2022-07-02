<?php

namespace App\Mrt\Doctor\Domain\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Doctor extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'doctor';

    protected $guard = "doctor";

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
            "type" => "doctor",
        ];
    }

    public function generateAuthToken()
    {
        return \JWTAuth::fromUser($this);
    }
}