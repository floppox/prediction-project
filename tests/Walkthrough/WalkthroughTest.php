<?php

namespace Tests\Walkthrough;
use Tests\TestCase;

class WalkthroughTest extends TestCase
{
    public function testAllApiEndpointsCalledInOrder ()
    {
        $this->artisan('migrate:refresh') ->assertExitCode(0);
        $this->artisan('db:seed')->assertExitCode(0);

        $this->post('/api/tournament/toss')
            ->assertStatus(200);

        $this->post('/api/tour/play')
            ->assertStatus(200);

        $this->get('/api/tournament/table')
            ->assertStatus(200);

        $this->get('/api/prediction')
            ->assertStatus(200);
    }
}