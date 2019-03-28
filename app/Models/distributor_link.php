<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class distributor_link
 * @package App\Models
 * @version March 13, 2019, 11:13 am UTC
 *
 * @property string name
 * @property string package
 * @property string price
 * @property string commission
 */
class distributor_link extends Model
{
    use SoftDeletes;

    public $table = 'distributor_links';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'package',
        'price',
        'commission',
        'link',
        'distributor',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'package' => 'string',
        'price' => 'string',
        'commission' => 'string',
        'link' => 'string',
        'distributor' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
