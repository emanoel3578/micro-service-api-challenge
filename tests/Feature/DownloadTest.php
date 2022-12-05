<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;

class DownloadTest extends TestCase
{
    public function test_should_fail_when_id_is_null()
    {
        $response = $this->json('GET', 'api/download', ['id' => null]);

        $response->assertStatus(422);
        $response->assertInvalid([
            'id' => "'id' field is required"
        ]);
    }

    public function test_should_fail_when_id_is_not_greater_than_zero()
    {
        $response = $this->json('GET', 'api/download', ['id' => 0]);

        $response->assertStatus(422);
        $response->assertInvalid([
            'id' => "'id' field must be greater than 0"
        ]);
    }

    public function test_should_fail_when_id_is_not_a_integer()
    {
        $response = $this->json('GET', 'api/download', ['id' => 3.1]);

        $response->assertStatus(422);
        $response->assertInvalid([
            'id' => "'id' field must be a valid integer number"
        ]);
    }

    public function test_should_fail_when_dateStart_is_not_a_date_valid_format()
    {
        $response = $this->json('GET', 'api/download', ['id' => 3, 'dateStart' => 123]);

        $response->assertStatus(422);
        $response->assertInvalid([
            'dateStart' => "'dateStart' field must be a valid date"
        ]);
    }

    public function test_should_fail_when_dateEnd_is_not_a_date_valid_format()
    {
        $response = $this->json('GET', 'api/download', ['id' => 3, 'dateEnd' => 123]);

        $response->assertStatus(422);
        $response->assertInvalid([
            'dateEnd' => "'dateEnd' field must be a valid date"
        ]);
    }

    public function test_should_succeed_when_id_is_valid()
    {
        $response = $this->json('GET', 'api/download', ['id' => 5]);

        $response->assertStatus(200);
    }

    public function test_should_succeed_when_dateStart_is_valid()
    {
        $response = $this->json('GET', 'api/download', ['id' => 5, 'dateStart' => Carbon::now()]);

        $response->assertStatus(200);
    }

    public function test_should_succeed_when_dateEnd_is_valid()
    {
        $response = $this->json('GET', 'api/download', ['id' => 5, 'dateEnd' => Carbon::now()]);

        $response->assertStatus(200);
    }

    public function test_should_succeed_when_all_parameters_are_valid()
    {
        $response = $this->json('GET', 'api/download', ['id' => 5, 'dateStart' => '2022-12-04 00:00:00' , 'dateEnd' => '2022-12-06 00:00:00']);

        $response->assertStatus(200);
    }
    
}
