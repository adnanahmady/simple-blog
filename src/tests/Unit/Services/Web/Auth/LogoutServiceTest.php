<?php

namespace Tests\Unit\Services\Web\Auth;

use App\Models\User;
use App\Services\Web\Auth\LogoutService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\TestCase;

#[CoversClass(LogoutService::class)]
class LogoutServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_should_logout_the_user(): void
    {
        $this->be(User::factory()->create());
        $service = new LogoutService();

        $service->logout();

        $this->assertFalse(Auth::hasUser());
    }
}
