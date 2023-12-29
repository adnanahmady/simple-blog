<?php

namespace Feature\Web\Articles;

use App\Http\Controllers\Web\ArticleController;
use App\Http\Requests\Web\Articles\UpdateRequest;
use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

#[CoversClass(ArticleController::class)]
#[CoversFunction('update')]
class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public static function dataProviderForDataValidation(): array
    {
        return [
            'title should have at least 5 characters length' => [[
                UpdateRequest::CONTENT => 'this is a content',
                UpdateRequest::TITLE => '5',
            ], UpdateRequest::TITLE],
            'title is required' => [[
                UpdateRequest::CONTENT => 'this is a content',
            ], UpdateRequest::TITLE],
            'content should have at least 10 character length' => [[
                UpdateRequest::TITLE => 'this is my title',
                UpdateRequest::CONTENT => 'a content',
            ], UpdateRequest::CONTENT],
            'content is required' => [[
                UpdateRequest::TITLE => 'this is my title',
            ], UpdateRequest::CONTENT],
        ];
    }

    #[DataProvider('dataProviderForDataValidation')]
    public function test_data_validation(array $data, string $errorField): void
    {
        $this->login();
        $article = Article::factory()->create();

        $response = $this->put(
            route('web.articles.update', $article),
            $data
        );

        $response->assertRedirect();
        $response->assertSessionHasErrors([$errorField]);
    }

    public function test_it_should_update_specified_article(): void
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
