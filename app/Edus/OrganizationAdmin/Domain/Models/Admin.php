<?php

namespace App\Edus\OrganizationAdmin\Domain\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'organization_admin';

    protected $guard = "organization";

    protected $guarded = ['id'];

    protected $hidden = ['last_visit', 'created_at', 'updated_at'];

    protected $custom_claims = ["type" => "organization"];

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
        return $this->custom_claims;
    }

    public function generateAuthToken(array $claims = array())
    {
        $this->custom_claims = array_merge($this->custom_claims, $claims);
        return \JWTAuth::fromUser($this);
    }
}