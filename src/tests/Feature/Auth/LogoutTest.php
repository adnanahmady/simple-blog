<?php

namespace Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_authorized_users_can_logout(): void
    {
        $response = $this->post(route('web.logout'));

        $response->assertRedirect(route('web.welcome'));
    }

    /** @test */
    public function user_can_logout(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->post(route('web.logout'));

        $response->assertRedirect();
        $this->assertFalse(Auth::hasUser());
    }
}
