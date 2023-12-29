<?php

namespace Feature\Web\Articles;

use App\Exceptions\AdminRequiredAccessException;
use App\Http\Requests\Web\Articles\ApproveRequest;
use App\Models\Article;
use App\Models\User;
use App\Repositories\PublicationStatusRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ApproveTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_admin_can_approve_or_disapprove_an_article(): void
    {
        $this->withoutExceptionHandling();
        $this->login();
        $article = Article::factory()->approved()->create();

        $this->expectException(AdminRequiredAccessException::class);

        $this->patch(
            route('web.articles.approval', $article),
            ['approved' => false]
        );
    }

    public static function dataProviderForDataValidation(): array
    {
        return [
            'approved field is required' => [[
            ], ApproveRequest::APPROVED],
            'approved field should be of type boolean' => [[
                ApproveRequest::APPROVED => 'string',
            ], ApproveRequest::APPROVED],
        ];
    }

    #[DataProvider('dataProviderForDataValidation')]
    public function test_data_validation(array $data, string $errorField): void
    {
        $this->adminLogin();
        $article = Article::factory()->create();

        $response = $this->patch(
            route('web.articles.approval', $article),
            $data
        );

        $response->assertRedirect();
        $response->assertSessionHasErrors([$errorField]);
    }

    public function test_an_article_can_get_disapproved(): void
    {
        $this->adminLogin();
        $statusRepository = new PublicationStatusRepository();
        $article = Article::factory()->approved()->create();

        $this->patch(
            route('web.articles.approval', $article),
            ['approved' => false]
        );

        $this->assertDatabaseHas(Article::TABLE, [
            Article::ID => $article->id(),
            Article::STATUS => $statusRepository->draft()->id(),
            Article::PUBLICATION_DATE => null,
        ]);
    }

    public function test_an_article_can_get_approved_to_publish(): void
    {
        $this->adminLogin();
        $statusRepository = new PublicationStatusRepository();
        $article = Article::factory()->create();

        $this->patch(
            route('web.articles.approval', $article),
            ['approved' => true]
        );

        $this->assertDatabaseHas(Article::TABLE, [
            Article::ID => $article->id(),
            Article::STATUS => $statusRepository->publish()->id(),
        ]);
    }

    public function login(): ApproveTest
    {
        return $this->be(User::factory()->create());
    }

    public function adminLogin(): ApproveTest
    {
        return $this->be(User::factory()->admin()->create());
    }
}
