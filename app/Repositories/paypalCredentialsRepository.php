<?php

namespace App\Repositories;

use App\Models\paypalCredentials;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class paypalCredentialsRepository
 * @package App\Repositories
 * @version September 17, 2018, 12:30 pm UTC
 *
 * @method paypalCredentials findWithoutFail($id, $columns = ['*'])
 * @method paypalCredentials find($id, $columns = ['*'])
 * @method paypalCredentials first($columns = ['*'])
*/
class paypalCredentialsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'client_id',
        'secret_id',
        'mode'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return paypalCredentials::class;
    }
}
