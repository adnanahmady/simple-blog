<?php

namespace Feature\Web\Manage;

use App\Exceptions\AdminRequiredAccessException;
use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RestoreFromTrashTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_admin_can_restore_from_trash(): void
    {
        $this->withoutExceptionHandling();
        $this->be(User::factory()->create());
        $trashedArticle = Article::factory()->trashed()->create();

        $this->expectException(AdminRequiredAccessException::class);

        $this->followingRedirects()->post(
            route(
                'web.trash.articles.restore',
                $trashedArticle
            )
        );
    }

    public function test_user_can_restore_trashed_articles(): void
    {
        $this->be(User::factory()->admin()->create());
        $trashedArticle = Article::factory()->trashed()->create();

        $response = $this
            ->followingRedirects()
            ->post(
                route(
                    'web.trash.articles.restore',
                    $trashedArticle
                )
            );

        $this->assertStringNotContainsString(
            $trashedArticle->title(),
            $response->content()
        );
    }
}
