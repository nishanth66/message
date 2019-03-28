<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class adddistributor
 * @package App\Models
 * @version October 17, 2018, 9:51 am UTC
 *
 * @property string name
 * @property string mail
 * @property string code
 * @property string comission
 */
class adddistributor extends Model
{
    use SoftDeletes;

    public $table = 'adddistributors';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'mail',
        'code',
        'comission'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'mail' => 'string',
        'code' => 'string',
        'comission' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
