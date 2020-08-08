<?php namespace Tests\Repositories;

use App\Models\Tasks;
use App\Repositories\TasksRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class TasksRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var TasksRepository
     */
    protected $tasksRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->tasksRepo = \App::make(TasksRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_tasks()
    {
        $tasks = factory(Tasks::class)->make()->toArray();

        $createdTasks = $this->tasksRepo->create($tasks);

        $createdTasks = $createdTasks->toArray();
        $this->assertArrayHasKey('id', $createdTasks);
        $this->assertNotNull($createdTasks['id'], 'Created Tasks must have id specified');
        $this->assertNotNull(Tasks::find($createdTasks['id']), 'Tasks with given id must be in DB');
        $this->assertModelData($tasks, $createdTasks);
    }

    /**
     * @test read
     */
    public function test_read_tasks()
    {
        $tasks = factory(Tasks::class)->create();

        $dbTasks = $this->tasksRepo->find($tasks->id);

        $dbTasks = $dbTasks->toArray();
        $this->assertModelData($tasks->toArray(), $dbTasks);
    }

    /**
     * @test update
     */
    public function test_update_tasks()
    {
        $tasks = factory(Tasks::class)->create();
        $fakeTasks = factory(Tasks::class)->make()->toArray();

        $updatedTasks = $this->tasksRepo->update($fakeTasks, $tasks->id);

        $this->assertModelData($fakeTasks, $updatedTasks->toArray());
        $dbTasks = $this->tasksRepo->find($tasks->id);
        $this->assertModelData($fakeTasks, $dbTasks->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_tasks()
    {
        $tasks = factory(Tasks::class)->create();

        $resp = $this->tasksRepo->delete($tasks->id);

        $this->assertTrue($resp);
        $this->assertNull(Tasks::find($tasks->id), 'Tasks should not exist in DB');
    }
}
