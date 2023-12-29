<?php

namespace Feature\Auth;

use App\Http\Controllers\Web\Auth\LoginController;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

#[CoversClass(LoginController::class)]
#[CoversFunction('index')]
class LoginPageTest extends TestCase
{
    /** @test */
    public function it_should_show_login_form(): void
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

    /** @test */
    public function welcome_page_should_show_login_page_link(): void
    {
        $response = $this->get('/');

        $this->assertStringContainsString(
            route('web.login'),
            $response->content()
        );
    }

    /** @test */
    public function login_should_response_ok(): void
    {
        $response = $this->get(route('web.login'));

        $response->assertOk();
    }
}
