<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\API\CreateTasksAPIRequest;
use App\Http\Requests\API\UpdateTasksAPIRequest;
use App\Models\Tasks as Tasks;
use App\Repositories\TasksRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use Carbon\Carbon as Carbon;

/**
 * Class TasksController
 * @package App\Http\Controllers\API
 */

class TasksAPIController extends AppBaseController
{
    /** @var  TasksRepository */
    private $tasksRepository;

    public function __construct(TasksRepository $tasksRepo)
    {
        $this->tasksRepository = $tasksRepo;
    }

    /**
     * Display a listing of the Tasks.
     * GET|HEAD /tasks
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $mytime = Carbon::now();
        $mytime= $mytime->today();
        $tasks = DB::table('tasks')->where('date', '=', $mytime)->orderBy('date')->get();
        

        return $this->sendResponse($tasks->toArray(), 'Tasks retrieved successfully');
    }


 


    /**
     * Store a newly created Tasks in storage.
     * POST /tasks
     *
     * @param CreateTasksAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateTasksAPIRequest $request)
    {
        $input = $request->all();

        $tasks = $this->tasksRepository->create($input);

        return $this->sendResponse($tasks->toArray(), 'Tasks saved successfully');
    }

    /**
     * Display the specified Tasks.
     * GET|HEAD /tasks/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Tasks $tasks */
        $tasks = $this->tasksRepository->find($id);

        if (empty($tasks)) {
            return $this->sendError('Tasks not found');
        }

        return $this->sendResponse($tasks->toArray(), 'Tasks retrieved successfully');
    }

    /**
     * Update the specified Tasks in storage.
     * PUT/PATCH /tasks/{id}
     *
     * @param int $id
     * @param UpdateTasksAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTasksAPIRequest $request)
    {
        $input = $request->all();

        /** @var Tasks $tasks */
        $tasks = $this->tasksRepository->find($id);

        if (empty($tasks)) {
            return $this->sendError('Tasks not found');
        }

        $tasks = $this->tasksRepository->update($input, $id);

        return $this->sendResponse($tasks->toArray(), 'Tasks updated successfully');
    }

    /**
     * Remove the specified Tasks from storage.
     * DELETE /tasks/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Tasks $tasks */
        $tasks = DB::table('tasks')->where('id','=',$id)->delete();

        

        return $this->sendSuccess('Tasks deleted successfully');
    }
}
