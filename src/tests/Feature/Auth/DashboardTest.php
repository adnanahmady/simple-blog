<?php

namespace Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_authenticated_users_should_be_able_to_see_it(): void
    {
        $response = $this->get(route('web.dashboard'));

        $response->assertRedirect();
    }

    /** @test */
    public function it_should_be_available(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get(route('web.dashboard'));

        $response->assertOk();
    }
}
