<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class distributor
 * @package App\Models
 * @version September 19, 2018, 4:21 am UTC
 *
 * @property string distributor_name
 * @property string email
 * @property string amount
 * @property string status
 */
class distributor extends Model
{
    use SoftDeletes;

    public $table = 'distributors';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'distributor_name',
        'email',
        'password',
        'real_pass',
        'amount',
        'private_key',
        'status',
        'code'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'distributor_name' => 'string',
        'email' => 'string',
        'amount' => 'string',
        'password' => 'string',
        'real_pass' => 'string',
        'private_key' => 'string',
        'status' => 'string',
        'code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'distributor_name' => 'required',
        'email' => 'required'
    ];

    
}
