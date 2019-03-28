<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class users extends Model
{
    use SoftDeletes;

    public $table = 'users';
    


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',

        'email',

        'password',

        'personalKey',

        'days_remember_to_login',

        'package',

        'real_pass',

        'private_key',

        'distributor_code',
        'status',
        'lastUpdated',
        'distributor_id',
        'lastreminder',
        'counter',
        'type',
        'reason',
        'package_type',
        'user_type',
        'public_key',
        'schedule_reminder',
    ];


    protected $casts = [
        'name' => 'string',

        'email' => 'string',

        'password' => 'string',

        'personalKey' => 'string',

        'days_remember_to_login' => 'string',

        'package' => 'string',

        'real_pass' => 'string',

        'private_key' => 'string',

        'distributor_code' => 'string',
        'status' => 'string',
        'lastUpdated' => 'string',
        'distributor_id' => 'string',
        'lastreminder' => 'string',
        'counter' => 'string',
        'type' => 'string',
        'reason' => 'string',
        'package_type' => 'string',
        'user_type' => 'string',
        'public_key' => 'string',
        'paypal_email' => 'string',
        'schedule_reminder' => 'string',
    ];


    public static $rules = [
        'name' => 'required',

        'email' => 'required',

        'password' => 'required',

        'personalKey' => 'required',

        'real_pass' => 'required',

//        'days_remember_to_login' => 'required',

//        'package' => 'required',

        'private_key' => 'required',

        'distributor_code' => 'required',
        'paypal_email' => 'required',
    ];

    
}
