<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Http\Controllers\Api\PredictionController;
use Tests\TestCase;

/**
 * Class PredictionControllerTest.
 *
 * @covers \App\Http\Controllers\Api\PredictionController
 */
class PredictionControllerTest extends TestCase
{
    public function test__invoke(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/api/prediction')
            ->assertStatus(200);
    }
}
