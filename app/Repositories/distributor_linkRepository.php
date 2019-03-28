<?php

namespace App\Repositories;

use App\Models\distributor_link;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class distributor_linkRepository
 * @package App\Repositories
 * @version March 13, 2019, 11:13 am UTC
 *
 * @method distributor_link findWithoutFail($id, $columns = ['*'])
 * @method distributor_link find($id, $columns = ['*'])
 * @method distributor_link first($columns = ['*'])
*/
class distributor_linkRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'package',
        'price',
        'commission'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return distributor_link::class;
    }
}
