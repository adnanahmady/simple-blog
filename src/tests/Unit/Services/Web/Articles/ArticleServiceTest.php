<?php

namespace Tests\Unit\Services\Web\Articles;

use App\Models\Article;
use App\Repositories\ArticleRepository;
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
    public function it_should_provide_the_list_of_articles(): void
    {
        Article::factory()->count(2)->create();
        $repository = new ArticleRepository();
        $service = new ArticleService($repository);

        $list = $service->all();

        $this->assertCount(2, $list);
    }
}
