<?php

namespace App\Repositories;

use App\Models\usermessage;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class usermessageRepository
 * @package App\Repositories
 * @version October 17, 2018, 6:19 am UTC
 *
 * @method usermessage findWithoutFail($id, $columns = ['*'])
 * @method usermessage find($id, $columns = ['*'])
 * @method usermessage first($columns = ['*'])
*/
class usermessageRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'message',
        'userid'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return usermessage::class;
    }
}
