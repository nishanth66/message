<?php

namespace App\Repositories;

use App\Models\adddistributor;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class adddistributorRepository
 * @package App\Repositories
 * @version October 17, 2018, 9:51 am UTC
 *
 * @method adddistributor findWithoutFail($id, $columns = ['*'])
 * @method adddistributor find($id, $columns = ['*'])
 * @method adddistributor first($columns = ['*'])
*/
class adddistributorRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'mail',
        'code',
        'comission'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return adddistributor::class;
    }
}
