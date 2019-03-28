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
class landing extends Model
{
    use SoftDeletes;

    public $table = 'landings';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'main_page_text',
        'sub_page_text',
        'main_image',
        'image',
        'email',
        'Address',
        'Phone'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'main_page_text' => 'string',
        'sub_page_text' => 'string',
        'main_image' => 'string',
        'image' => 'string',
        'email' => 'string',
        'Address' => 'string',
        'Phone' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
