<?php

namespace App\Repositories;

use App\Models\distributor;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class distributorRepository
 * @package App\Repositories
 * @version September 19, 2018, 4:21 am UTC
 *
 * @method distributor findWithoutFail($id, $columns = ['*'])
 * @method distributor find($id, $columns = ['*'])
 * @method distributor first($columns = ['*'])
*/
class distributorRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'distributor_name',
        'email',
        'amount',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return distributor::class;
    }
}
