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
class logo extends Model
{
    use SoftDeletes;

    public $table = 'logo';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'image',
        'status',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'image' => 'string',
        'status' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'image' => 'required',
        'status' => 'required',
    ];


}
