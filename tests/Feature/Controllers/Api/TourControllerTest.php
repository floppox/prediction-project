<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Http\Controllers\Api\TourController;
use App\Services\TourManagementService;
use Mockery;
use Mockery\Mock;
use Tests\TestCase;

/**
 * Class TourControllerTest.
 *
 * @covers \App\Http\Controllers\Api\TourController
 */
class TourControllerTest extends TestCase
{
    public function testShow(): void
    {
        $this->get('/api/tour/1')
            ->assertStatus(200);
    }

    public function testIndex(): void
    {
        $this->get('/api/tour/list')
            ->assertStatus(200);
    }

    public function testPlayNextTour(): void
    {
        $this->post('/api/tour/play')
            ->assertStatus(404);
    }
}
