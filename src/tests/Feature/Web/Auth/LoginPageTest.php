<?php

namespace Feature\Web\Auth;

use App\Http\Controllers\Web\Auth\LoginController;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use Tests\TestCase;

#[CoversClass(LoginController::class)]
#[CoversFunction('index')]
class LoginPageTest extends TestCase
{
    public function test_only_unauthorized_users_can_see_login_page(): void
    {
        $route = route('web.login');
        $this->be(User::factory()->create());

        $response = $this->get($route);

        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_it_should_show_login_form(): void
    {
        $route = route('web.login');
        $expectations = [
            'action="' . route('web.login.store'),
            'method="POST"',
            'name="email"',
            'name="password"',
            'type="submit"',
            'Login',
        ];

        $response = $this->get($route);

        foreach ($expectations as $expect) {
            $this->assertStringContainsString(
                $expect,
                $response->content()
            );
        }
    }

    public function test_welcome_page_should_show_login_page_link(): void
    {
        $response = $this->get('/');

        $this->assertStringContainsString(
            route('web.login'),
            $response->content()
        );
    }

    public function test_login_should_response_ok(): void
    {
        $response = $this->get(route('web.login'));

        $response->assertOk();
    }
}
