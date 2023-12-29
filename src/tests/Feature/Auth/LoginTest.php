<?php

namespace Feature\Auth;

use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Requests\Web\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
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

    /** @test */
    public function only_unauthorized_users_can_login(): void
    {
        $user = User::factory()->create([
            User::PASSWORD => $password = 'secret',
        ]);
        $this->be(User::factory()->create());
        $data = ['email' => $user->email(), 'password' => $password];

        $response = $this->post(route('web.login.store'), $data);

        $response->assertRedirect(RouteServiceProvider::HOME);
        $this->assertNotSame($user->id(), Auth::user()->id());
    }

    public static function dataProviderForDataValidation(): array
    {
        return [
            'password should be at least 6 characters length' => [[
                LoginRequest::EMAIL => 'secret@email.com',
                LoginRequest::PASSWORD => '12345',
            ], LoginRequest::PASSWORD],
            'password is required' => [[
                LoginRequest::EMAIL => 'secret@email.com',
            ], LoginRequest::PASSWORD],
            'email should be a formed text' => [[
                LoginRequest::EMAIL => 'secret',
                LoginRequest::PASSWORD => 'secret',
            ], LoginRequest::EMAIL],
            'email is required' => [[
                LoginRequest::PASSWORD => 'secret',
            ], LoginRequest::EMAIL],
        ];
    }

    /** @test */
    #[DataProvider('dataProviderForDataValidation')]
    public function data_validation(array $data, string $errorKey): void
    {
        User::factory()->create($data);

        $response = $this->post(route('web.login.store'), $data);

        $response->assertRedirect();
        $response->assertSessionHasErrors([$errorKey]);
    }

    /** @test */
    public function user_should_be_logged_in(): void
    {
        $user = User::factory()->create([
            User::PASSWORD => $password = 'secret',
        ]);
        $data = [
            'email' => $user->email(),
            'password' => $password,
        ];

        $this->post(route('web.login.store'), $data);

        $this->assertNotNull(Auth::user());
    }

    /** @test */
    // phpcs:ignore
    public function user_should_be_redirected_back_to_login_when_unsuccessful_login(): void
    {
        $data = [
            'email' => 'invalid@email.com',
            'password' => 'password',
        ];

        $response = $this->post(route('web.login.store'), $data);

        $response->assertRedirect(route('web.login'));
        $response->assertSessionHasErrors();
    }

    /** @test */
    // phpcs:ignore
    public function user_should_redirect_to_dashboard_after_successfully_logged_in(): void
    {
        $user = User::factory()->create([
            User::PASSWORD => $password = 'secret',
        ]);
        $data = [
            'email' => $user->email(),
            'password' => $password,
        ];

        $response = $this->post(route('web.login.store'), $data);

        $response->assertRedirect(url('/dashboard'));
        $response->assertSessionHasNoErrors();
    }
}
