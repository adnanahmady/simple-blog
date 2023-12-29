<?php

namespace Feature\Web\Articles;

use App\Http\Controllers\Web\ArticleController;
use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use Tests\TestCase;

#[CoversClass(ArticleController::class)]
#[CoversFunction('show')]
class ShowPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_authorized_users_can_view_it(): void
    {
        $article = Article::factory()->create();

        $response = $this->get(route('web.articles.show', $article));

        $response->assertRedirect(route('web.welcome'));
    }

    /** @test */
    public function it_should_show_required_form_to_create(): void
    {
        $this->login();
        $articles = Article::factory()->count(3)->create();
        $expectations = [
            $articles[1]->title(),
            $articles[1]->content(),
            $articles[1]->author->name,
            $articles[1]->status->title,
            $articles[1]->publicationDate()->format('Y-m-d H:i:s'),
        ];

        $response = $this->get(
            route('web.articles.show', $articles[1])
        );

        foreach ($expectations as $expectation) {
            $this->assertStringContainsString(
                $expectation,
                $response->content()
            );
        }
        $response->assertOk();
    }

    public function login(): void
    {
        $this->be(User::factory()->create());
    }
}
