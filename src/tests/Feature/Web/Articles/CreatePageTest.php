<?php

namespace Feature\Web\Articles;

use App\Http\Controllers\Web\ArticleController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use Tests\TestCase;

#[CoversClass(ArticleController::class)]
#[CoversFunction('create')]
class CreatePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_should_show_required_form_to_create(): void
    {
        $this->login();
        $expectations = [
            'Article Title',
            'input type="text',
            'Article Content',
            'textarea',
            'button type="submit',
            'Create Article',
        ];

        $response = $this->get(route('web.articles.create'));

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
