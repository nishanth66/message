<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class paypalCredentials
 * @package App\Models
 * @version September 17, 2018, 12:30 pm UTC
 *
 * @property string client_id
 * @property string secret_id
 * @property string mode
 */
class paypalCredentials extends Model
{
    use SoftDeletes;

    public $table = 'paypal_credentials';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'name',
        'email',
        'package',
        'payment_id',
        'paymentDate',
        'packageExpireDate',
        'phone',
        'country',
        'city',
        'zipcode',
        'type',
        'street',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'string',
        'name' => 'string',
        'email' => 'string',
        'package' => 'string',
        'payment_id' => 'string',
        'paymentDate' => 'string',
        'packageExpireDate' => 'string',
        'phone' => 'string',
        'country' => 'string',
        'city' => 'string',
        'zipcode' => 'string',
        'type' => 'string',
        'street' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    
}
