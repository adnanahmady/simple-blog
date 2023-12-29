<?php

namespace Tests\Unit\Services\Web\Articles;

use App\Models\Article;
use App\Models\User;
use App\Repositories\ArticleRepository;
use App\Repositories\PublicationStatusRepository;
use App\Services\Web\Auth\ArticleService;
use App\Services\Web\Auth\LogoutService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\TestCase;

#[CoversClass(LogoutService::class)]
class ArticleServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_should_be_able_to_return_a_specific_article(): void
    {
        $statusRepository = new PublicationStatusRepository();
        $repository = new ArticleRepository($statusRepository);
        $service = new ArticleService($repository);
        $article = Article::factory()->trashed()->create();

        $service->restore(article: $article);

        $this->assertDatabaseHas(Article::TABLE, [
            Article::ID => $article->id(),
            Article::DELETED_AT => null,
        ]);
    }

    public function test_it_should_return_trashed_articles(): void
    {
        $statusRepository = new PublicationStatusRepository();
        $repository = new ArticleRepository($statusRepository);
        $service = new ArticleService($repository);
        Article::factory()->create();
        Article::factory()->trashed()->count($count = 4)->create();

        $trashedArticles = $service->trash();

        $this->assertCount($count, $trashedArticles);
    }

    public function test_it_can_disapprove_an_articles(): void
    {
        $statusRepository = new PublicationStatusRepository();
        $repository = new ArticleRepository($statusRepository);
        $service = new ArticleService($repository);
        $article = Article::factory()->create();

        $service->doApproval(
            article: $article,
            isApproved: false
        );

        $this->assertDatabaseHas(Article::TABLE, [
            Article::ID => $article->id(),
            Article::STATUS => $statusRepository->draft()->id(),
            Article::PUBLICATION_DATE => null,
        ]);
    }

    public function test_it_can_approve_an_articles(): void
    {
        $statusRepository = new PublicationStatusRepository();
        $repository = new ArticleRepository($statusRepository);
        $service = new ArticleService($repository);
        $article = Article::factory()->create();

        $service->doApproval(
            article: $article,
            isApproved: true
        );

        $this->assertDatabaseHas(Article::TABLE, [
            Article::ID => $article->id(),
            Article::STATUS => $statusRepository->publish()->id(),
            Article::PUBLICATION_DATE => now(),
        ]);
    }

    public function test_it_can_update_article(): void
    {
        $statusRepository = new PublicationStatusRepository();
        $repository = new ArticleRepository($statusRepository);
        $service = new ArticleService($repository);
        $article = Article::factory()->create();

        $service->update(
            article: $article,
            title: $title = 'title',
            content: $content = 'content',
        );

        $this->assertDatabaseHas(Article::TABLE, [
            Article::ID => $article->id(),
            Article::TITLE => $title,
            Article::CONTENT => $content,
        ]);
    }

    public function test_it_can_create_article(): void
    {
        $statusRepository = new PublicationStatusRepository();
        $repository = new ArticleRepository($statusRepository);
        $service = new ArticleService($repository);

        $service->create(
            title: $title = 'title',
            content: $content = 'content',
            author: $author = User::factory()->create(),
        );

        $this->assertDatabaseHas(Article::TABLE, [
            Article::TITLE => $title,
            Article::CONTENT => $content,
            Article::AUTHOR => $author->id(),
            Article::STATUS => $statusRepository->draft()->id(),
            Article::PUBLICATION_DATE => null,
        ]);
    }

    public function test_it_should_provide_the_list_of_articles(): void
    {
        Article::factory()->count(2)->create();
        $repository = new ArticleRepository(
            new PublicationStatusRepository()
        );
        $service = new ArticleService($repository);

        $list = $service->all();

        $this->assertCount(2, $list);
    }
}
