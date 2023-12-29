<?php

namespace Feature\Web\Articles;

use App\Http\Controllers\Web\ArticleController;
use App\Models\Article;
use App\Models\User;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use Tests\TestCase;

#[CoversClass(ArticleController::class)]
#[CoversFunction('edit')]
class EditPageTest extends TestCase
{
    /** @test */
    public function it_should_show_required_form_to_create(): void
    {
        $this->login();
        $article = Article::factory()->create();
        $expectations = [
            'Article Title',
            'input type="text',
            'Article Content',
            'textarea',
            'button type="submit',
            'Create Article',
            $article->title(),
            $article->content(),
        ];

        $response = $this->get(route('web.articles.edit', $article));

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