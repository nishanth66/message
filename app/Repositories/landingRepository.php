<?php

namespace App\Repositories;

use App\Models\landing;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class landingRepository
 * @package App\Repositories
 * @version September 18, 2018, 6:21 am UTC
 *
 * @method landing findWithoutFail($id, $columns = ['*'])
 * @method landing find($id, $columns = ['*'])
 * @method landing first($columns = ['*'])
*/
class landingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'page_text',
        'image',
        'email',
        'Address',
        'Phone'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return landing::class;
    }
}
