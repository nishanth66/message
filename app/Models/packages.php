<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class packages
 * @package App\Models
 * @version September 17, 2018, 5:55 am UTC
 *
 * @property string subscrption_name
 * @property string amount
 * @property string setup_charges
 * @property string qty_of_alarms
 * @property string no_of_days
 */
class packages extends Model
{
    use SoftDeletes;

    public $table = 'packages';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'package_name',
        'no_of_limit_messages',
        'initial_setup',
        'yearly_subscribe',
        'package_class',
        'features',
        'commission',
//        'package_type'

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'package_name' => 'string',
        'no_of_limit_messages' => 'string',
        'initial_setup' => 'string',
        'yearly_subscribe' => 'string',
        'package_class' => 'string',
        'features' => 'string',
        'commission' => 'string',
//        'package_type' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'package_name' => 'required',
        'no_of_limit_messages' => 'required',
        'initial_setup' => 'required',
        'yearly_subscribe' => 'required',
        'package_class' => 'required',
        'features' => 'required',
    ];

    
}
