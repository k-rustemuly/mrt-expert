<?php

namespace App\Mrt\SuperAdmin\Domain\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class SuperAdmin extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'super_admin';

    protected $guard = "super_admin";

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
            "type" => "super_admin",
        ];
    }

    public function generateAuthToken()
    {
        return \JWTAuth::fromUser($this);
    }
}