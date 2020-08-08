<?php

namespace App\Http\Controllers;

use App\Http\Requests\API\CreateWeatherAPIRequest;
use App\Http\Requests\API\UpdateWeatherAPIRequest;
use App\Models\Weather;
use Illuminate\Support\Facades\DB;
use App\Repositories\WeatherRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class WeatherController
 * @package App\Http\Controllers\API
 */

class WeatherAPIController extends AppBaseController
{
    /** @var  WeatherRepository */
    private $weatherRepository;

    public function __construct(WeatherRepository $weatherRepo)
    {
        $this->weatherRepository = $weatherRepo;
    }

    /**
     * Display a listing of the Weather.
     * GET|HEAD /weather
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $weather = $this->weatherRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($weather->toArray(), 'Weather retrieved successfully');
    }

    /**
     * Store a newly created Weather in storage.
     * POST /weather
     *
     * @param CreateWeatherAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateWeatherAPIRequest $request)
    {
        $input = $request->all();

        $weather = $this->weatherRepository->create($input);

        return $this->sendResponse($weather->toArray(), 'Weather saved successfully');
    }

    /**
     * Display the specified Weather.
     * GET|HEAD /weather/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show(Request $request)
    {
        /** @var Weather $weather */
        
        $location = $request->location;
        $tasks = DB::table('weather')->where('location','=',$location)->get();

        if (empty($tasks)) {
            return $this->sendError('Weather not found');
        }

        return $this->sendResponse($tasks->toArray(), 'Weather retrieved successfully');
    }

    /**
     * Update the specified Weather in storage.
     * PUT/PATCH /weather/{id}
     *
     * @param int $id
     * @param UpdateWeatherAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateWeatherAPIRequest $request)
    {
        $input = $request->all();

        /** @var Weather $weather */
        $weather = $this->weatherRepository->find($id);

        if (empty($weather)) {
            return $this->sendError('Weather not found');
        }

        $weather = $this->weatherRepository->update($input, $id);

        return $this->sendResponse($weather->toArray(), 'Weather updated successfully');
    }

    /**
     * Remove the specified Weather from storage.
     * DELETE /weather/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Weather $weather */
        $weather = $this->weatherRepository->find($id);

        if (empty($weather)) {
            return $this->sendError('Weather not found');
        }

        $weather->delete();

        return $this->sendSuccess('Weather deleted successfully');
    }


}
