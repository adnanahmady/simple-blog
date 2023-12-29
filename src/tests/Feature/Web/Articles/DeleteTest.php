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
#[CoversFunction('destroy')]
class DeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_trash_the_article_instead_of_deleting_it(): void
    {
        $this->login();
        $article = Article::factory()->create();

        $response = $this->delete(
            route('web.articles.delete', $article)
        );

        $this->assertDatabaseHas(Article::TABLE, [
            Article::ID => $article->id(),
        ]);
        $this->assertDatabaseMissing(Article::TABLE, [
            Article::ID => $article->id(),
            Article::DELETED_AT => null,
        ]);
    }

    /** @test */
    public function it_should_delete_specified_article(): void
    {
        $this->login();
        $article = Article::factory()->create();

        $response = $this->delete(
            route('web.articles.delete', $article)
        );

        $this->assertStringNotContainsString(
            $article->title(),
            $response->content()
        );
    }

    public function login(): void
    {
        $this->be(User::factory()->create());
    }
}
