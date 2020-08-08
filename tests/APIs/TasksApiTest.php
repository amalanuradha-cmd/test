<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Tasks;

class TasksApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_tasks()
    {
        $tasks = factory(Tasks::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/tasks', $tasks
        );

        $this->assertApiResponse($tasks);
    }

    /**
     * @test
     */
    public function test_read_tasks()
    {
        $tasks = factory(Tasks::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/tasks/'.$tasks->id
        );

        $this->assertApiResponse($tasks->toArray());
    }

    /**
     * @test
     */
    public function test_update_tasks()
    {
        $tasks = factory(Tasks::class)->create();
        $editedTasks = factory(Tasks::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/tasks/'.$tasks->id,
            $editedTasks
        );

        $this->assertApiResponse($editedTasks);
    }

    /**
     * @test
     */
    public function test_delete_tasks()
    {
        $tasks = factory(Tasks::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/tasks/'.$tasks->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/tasks/'.$tasks->id
        );

        $this->response->assertStatus(404);
    }
}
