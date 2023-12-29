<?php

namespace Feature\Web\Articles;

use App\Http\Controllers\Web\ArticleController;
use App\Http\Requests\Web\Articles\UpdateRequest;
use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use Tests\TestCase;

#[CoversClass(ArticleController::class)]
#[CoversFunction('update')]
class UpdateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_update_specified_article(): void
    {
        $this->login();
        $article = Article::factory()->create();
        $data = [
            UpdateRequest::TITLE => 'some title',
            UpdateRequest::CONTENT => 'some content for replacement',
        ];

        $response = $this->followingRedirects()->put(
            route('web.articles.update', $article),
            $data
        );

        foreach ($data as $expectation) {
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
