<?php

namespace Feature\Web\Manage;

use App\Exceptions\AdminRequiredAccessException;
use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrashPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_admin_can_see_trash_page(): void
    {
        $this->withoutExceptionHandling();
        $this->be(User::factory()->create());
        $trashedArticle = Article::factory()->trashed()->create();
        $article = Article::factory()->create();

        $this->expectException(AdminRequiredAccessException::class);

        $response = $this->get(route('web.trash'));
    }

    public function test_it_should_show_trashed_articles(): void
    {
        $this->be(User::factory()->admin()->create());
        $trashedArticle = Article::factory()->trashed()->create();
        $article = Article::factory()->create();

        $response = $this->get(route('web.trash'));

        $this->assertStringContainsString(
            $trashedArticle->title(),
            $response->content()
        );
        $this->assertStringNotContainsString(
            $article->title(),
            $response->content()
        );
    }
}
