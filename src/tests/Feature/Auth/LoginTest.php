<?php

namespace Feature\Auth;

use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Requests\Web\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

#[CoversClass(LoginController::class)]
#[CoversFunction('store')]
class LoginTest extends TestCase
{
    use RefreshDatabase;

    public static function dataProviderForDataValidation(): array
    {
        return [
            'password should be at least 6 characters length' => [[
                LoginRequest::EMAIL => 'secret@email.com',
                LoginRequest::PASSWORD => '12345'
            ], LoginRequest::PASSWORD],
            'password is required' => [[
                LoginRequest::EMAIL => 'secret@email.com',
            ], LoginRequest::PASSWORD],
            'email should be a formed text' => [[
                LoginRequest::EMAIL => 'secret',
                LoginRequest::PASSWORD => 'secret'
            ], LoginRequest::EMAIL],
            'email is required' => [[
                LoginRequest::PASSWORD => 'secret'
            ], LoginRequest::EMAIL],
        ];
    }

    #[DataProvider('dataProviderForDataValidation')]
    public function testDataValidation(array $data, string $errorKey): void
    {
        User::factory()->create($data);

        $response = $this->post(route('web.login.store'), $data);

        $response->assertRedirect();
        $response->assertSessionHasErrors([$errorKey]);
    }

    public function testUserShouldBeLoggedIn(): void
    {
        $user = User::factory()->create([
            User::PASSWORD => $password = 'secret'
        ]);
        $data = [
            'email' => $user->email(),
            'password' => $password
        ];

        $this->post(route('web.login.store'), $data);

        $this->assertNotNull(Auth::user());
    }

    public function testUserShouldBeRedirectedBackToLoginWhenUnsuccessfulLogin(): void
    {
        $data = [
            'email' => 'invalid@email.com',
            'password' => 'password'
        ];

        $response = $this->post(route('web.login.store'), $data);

        $response->assertRedirect(route('web.login'));
        $response->assertSessionHasErrors();
    }

    public function testUserShouldRedirectToDashboardAfterSuccessfullyLoggedIn(): void
    {
        $user = User::factory()->create([
            User::PASSWORD => $password = 'secret'
        ]);
        $data = [
            'email' => $user->email(),
            'password' => $password
        ];

        $response = $this->post(route('web.login.store'), $data);

        $response->assertRedirect(url('/dashboard'));
        $response->assertSessionHasNoErrors();
    }
}
