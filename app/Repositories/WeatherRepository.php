<?php

namespace App\Repositories;

use App\Models\Weather;
use App\Repositories\BaseRepository;

/**
 * Class WeatherRepository
 * @package App\Repositories
 * @version August 8, 2020, 7:45 pm UTC
*/

class WeatherRepository extends BaseRepository
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
        return Weather::class;
    }
}
