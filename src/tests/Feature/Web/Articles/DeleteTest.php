<?php

namespace Feature\Web\Articles;

use App\Exceptions\AdminRequiredAccessException;
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
    public function only_admin_can_delete_an_article(): void
    {
        $this->withoutExceptionHandling();
        $this->login();
        $article = Article::factory()->create();

        $this->expectException(AdminRequiredAccessException::class);

        $this->delete(
            route('web.articles.delete', $article)
        );
    }

    /** @test */
    public function it_should_trash_the_article_instead_of_deleting_it(): void
    {
        $this->adminLogin();
        $article = Article::factory()->create();

        $this->delete(
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
        $this->adminLogin();
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

    public function adminLogin(): void
    {
        $this->be(User::factory()->admin()->create());
    }
}
