<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    protected $fillable = [
        'name', 'email', 'password','real_pass','personalKey','lastUpdated','package','days_remember_to_login','private_key','public_key','distributor_code','status','lastreminder','counter','type','reason','package_type','user_type','paypal_email','lastUpdated','schedule_reminder'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
