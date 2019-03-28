<?php

namespace App\Repositories;

use App\Models\packages;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class packagesRepository
 * @package App\Repositories
 * @version September 17, 2018, 5:55 am UTC
 *
 * @method packages findWithoutFail($id, $columns = ['*'])
 * @method packages find($id, $columns = ['*'])
 * @method packages first($columns = ['*'])
*/
class packagesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'subscrption_name',
        'amount',
        'setup_charges',
        'qty_of_alarms',
        'no_of_days'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return packages::class;
    }
}
