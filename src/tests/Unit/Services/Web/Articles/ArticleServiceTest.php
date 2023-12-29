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

    /** @test */
    public function it_can_disapprove_an_articles(): void
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

    /** @test */
    public function it_can_approve_an_articles(): void
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

    /** @test */
    public function it_can_update_article(): void
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

    /** @test */
    public function it_can_create_article(): void
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

    /** @test */
    public function it_should_provide_the_list_of_articles(): void
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
