<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Http\Controllers\Api\TournamentController;
use App\Services\TournamentManagementService;
use Mockery;
use Mockery\Mock;
use Tests\TestCase;

/**
 * Class TournamentControllerTest.
 *
 * @covers \App\Http\Controllers\Api\TournamentController
 */
class TournamentControllerTest extends TestCase
{
    public function testShowTable(): void
    {
        $this->get('/api/tournament/table')
            ->assertStatus(200);
    }

    public function testCoinToss(): void
    {
        $this->post('/api/tournament/toss')
            ->assertStatus(200);
    }
}
