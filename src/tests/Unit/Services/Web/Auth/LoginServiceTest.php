<?php

namespace Tests\Unit\Services\Web\Auth;

use App\Http\Requests\Web\Auth\LoginRequest;
use App\Models\User;
use App\Services\Web\Auth\LoginService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\TestCase;

#[CoversClass(LoginService::class)]
class LoginServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_should_attempt_to_login_the_user(): void
    {
        $user = User::factory()->create([
            User::PASSWORD => $password = 'password',
        ]);
        $request = new LoginRequest([
            LoginRequest::EMAIL => $user->email(),
            LoginRequest::PASSWORD => $password,
        ]);
        $service = new LoginService($request);

        $service->attempt();

        $this->assertTrue(Auth::hasUser());
    }
}
