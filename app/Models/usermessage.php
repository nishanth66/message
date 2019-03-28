<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class usermessage
 * @package App\Models
 * @version October 17, 2018, 6:19 am UTC
 *
 * @property string message
 */
class usermessage extends Model
{
    use SoftDeletes;

    public $table = 'usermessages';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'message',
        'userid',
        'msgid',
        'emails',
        'day',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'message' => 'string',
        'userid' => 'string',
        'msgid' => 'string',
        'emails' => 'string',
        'day' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'message' => 'required',
        'msgid' => 'required',
        'day' => 'required',
    ];

    
}
