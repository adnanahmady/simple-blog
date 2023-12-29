<?php

namespace Feature\Web;

use App\Http\Controllers\Web\DashboardController;
use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use Tests\TestCase;

#[CoversClass(DashboardController::class)]
#[CoversFunction('index')]
class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_show_the_list_of_articles(): void
    {
        $this->login();
        $article = Article::factory()->approved()->create();
        $expectations = [
            $article->title(),
            $article->content(),
            $article->author->name,
            $article->publicationDate()->format('Y-m-d H:i:s'),
        ];

        $response = $this->get(route('web.dashboard'));

        foreach ($expectations as $expectation) {
            $this->assertStringContainsString(
                $expectation,
                $response->content()
            );
        }
    }

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

    public function login(): void
    {
        $this->be(User::factory()->create());
    }
}
