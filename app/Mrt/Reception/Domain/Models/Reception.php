<?php

namespace App\Mrt\Reception\Domain\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Reception extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'reception';

    protected $guard = "reception";

    protected $guarded = ['id'];

    protected $hidden = ['password', 'created_at', 'updated_at'];

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
            "type" => "reception",
        ];
    }

    public function generateAuthToken()
    {
        return \JWTAuth::fromUser($this);
    }
}