<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Weather;

class WeatherApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_weather()
    {
        $weather = factory(Weather::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/weather', $weather
        );

        $this->assertApiResponse($weather);
    }

    /**
     * @test
     */
    public function test_read_weather()
    {
        $weather = factory(Weather::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/weather/'.$weather->id
        );

        $this->assertApiResponse($weather->toArray());
    }

    /**
     * @test
     */
    public function test_update_weather()
    {
        $weather = factory(Weather::class)->create();
        $editedWeather = factory(Weather::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/weather/'.$weather->id,
            $editedWeather
        );

        $this->assertApiResponse($editedWeather);
    }

    /**
     * @test
     */
    public function test_delete_weather()
    {
        $weather = factory(Weather::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/weather/'.$weather->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/weather/'.$weather->id
        );

        $this->response->assertStatus(404);
    }
}
