<?php namespace Tests\Repositories;

use App\Models\Weather;
use App\Repositories\WeatherRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class WeatherRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var WeatherRepository
     */
    protected $weatherRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->weatherRepo = \App::make(WeatherRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_weather()
    {
        $weather = factory(Weather::class)->make()->toArray();

        $createdWeather = $this->weatherRepo->create($weather);

        $createdWeather = $createdWeather->toArray();
        $this->assertArrayHasKey('id', $createdWeather);
        $this->assertNotNull($createdWeather['id'], 'Created Weather must have id specified');
        $this->assertNotNull(Weather::find($createdWeather['id']), 'Weather with given id must be in DB');
        $this->assertModelData($weather, $createdWeather);
    }

    /**
     * @test read
     */
    public function test_read_weather()
    {
        $weather = factory(Weather::class)->create();

        $dbWeather = $this->weatherRepo->find($weather->id);

        $dbWeather = $dbWeather->toArray();
        $this->assertModelData($weather->toArray(), $dbWeather);
    }

    /**
     * @test update
     */
    public function test_update_weather()
    {
        $weather = factory(Weather::class)->create();
        $fakeWeather = factory(Weather::class)->make()->toArray();

        $updatedWeather = $this->weatherRepo->update($fakeWeather, $weather->id);

        $this->assertModelData($fakeWeather, $updatedWeather->toArray());
        $dbWeather = $this->weatherRepo->find($weather->id);
        $this->assertModelData($fakeWeather, $dbWeather->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_weather()
    {
        $weather = factory(Weather::class)->create();

        $resp = $this->weatherRepo->delete($weather->id);

        $this->assertTrue($resp);
        $this->assertNull(Weather::find($weather->id), 'Weather should not exist in DB');
    }
}
