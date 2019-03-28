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
class schedule extends Model
{
    use SoftDeletes;

    public $table = 'schedule';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'msg_to',
        'msg_body',
        'sent_date',
        'status',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'msg_to' => 'string',
        'msg_body' => 'string',
        'sent_date' => 'string',
        'status' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'msg_to' => 'required',
        'msg_body' => 'required',
        'sent_date' => 'required',
        'status' => 'required',
    ];


}
