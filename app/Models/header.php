<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class landing
 * @package App\Models
 * @version September 18, 2018, 6:21 am UTC
 *
 * @property string page_text
 * @property string image
 * @property string email
 * @property string Address
 * @property string Phone
 */
class header extends Model
{
    use SoftDeletes;

    public $table = 'header';
    protected $dates = ['deleted_at'];

    public $fillable = [
        'title',
        'url'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'url' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
