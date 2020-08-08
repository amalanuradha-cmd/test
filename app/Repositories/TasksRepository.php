<?php

namespace App\Repositories;

use App\Models\Tasks;
use App\Repositories\BaseRepository;

/**
 * Class TasksRepository
 * @package App\Repositories
 * @version August 8, 2020, 11:10 am UTC
*/

class TasksRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Tasks::class;
    }
}
