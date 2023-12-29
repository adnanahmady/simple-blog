<?php

namespace Tests\Unit\Services\Web\Auth;

use App\Models\User;
use App\Services\Web\Auth\LogoutService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LogoutServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_logout_the_user(): void
    {
        $this->be(User::factory()->create());
        $service = new LogoutService();

        $service->logout();

        $this->assertFalse(Auth::hasUser());
    }
}
