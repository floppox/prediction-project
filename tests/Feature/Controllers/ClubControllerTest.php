<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Club;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClubControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_clubs()
    {
        $clubs = Club::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('clubs.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.clubs.index')
            ->assertViewHas('clubs');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_club()
    {
        $response = $this->get(route('clubs.create'));

        $response->assertOk()->assertViewIs('app.clubs.create');
    }

    /**
     * @test
     */
    public function it_stores_the_club()
    {
        $data = Club::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('clubs.store'), $data);

        $this->assertDatabaseHas('clubs', $data);

        $club = Club::latest('id')->first();

        $response->assertRedirect(route('clubs.edit', $club));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_club()
    {
        $club = Club::factory()->create();

        $response = $this->get(route('clubs.show', $club));

        $response
            ->assertOk()
            ->assertViewIs('app.clubs.show')
            ->assertViewHas('club');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_club()
    {
        $club = Club::factory()->create();

        $response = $this->get(route('clubs.edit', $club));

        $response
            ->assertOk()
            ->assertViewIs('app.clubs.edit')
            ->assertViewHas('club');
    }

    /**
     * @test
     */
    public function it_updates_the_club()
    {
        $club = Club::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'notional_strength' => $this->faker->randomNumber(0),
        ];

        $response = $this->put(route('clubs.update', $club), $data);

        $data['id'] = $club->id;

        $this->assertDatabaseHas('clubs', $data);

        $response->assertRedirect(route('clubs.edit', $club));
    }

    /**
     * @test
     */
    public function it_deletes_the_club()
    {
        $club = Club::factory()->create();

        $response = $this->delete(route('clubs.destroy', $club));

        $response->assertRedirect(route('clubs.index'));

        $this->assertDeleted($club);
    }
}
