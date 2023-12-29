<?php

namespace Tests\Feature\Web\Articles;

use App\Http\Requests\Web\Articles\CreateRequest;
use App\Models\User;
use App\Repositories\PublicationStatusRepository;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public static function dataProviderForDataValidation(): array
    {
        return [
            'title should have at least 5 characters length' => [[
                CreateRequest::CONTENT => 'this is a content',
                CreateRequest::TITLE => '5',
            ], CreateRequest::TITLE],
            'title is required' => [[
                CreateRequest::CONTENT => 'this is a content',
            ], CreateRequest::TITLE],
            'content should have at least 10 character length' => [[
                CreateRequest::TITLE => 'this is my title',
                CreateRequest::CONTENT => 'a content',
            ], CreateRequest::CONTENT],
            'content is required' => [[
                CreateRequest::TITLE => 'this is my title',
            ], CreateRequest::CONTENT],
        ];
    }

    /** @test */
    #[DataProvider('dataProviderForDataValidation')]
    public function data_validation(array $data, string $errorField): void
    {
        $this->login();

        $response = $this->post(
            route('web.articles.store'),
            $data
        );

        $response->assertRedirect();
        $response->assertSessionHasErrors([$errorField]);
    }

    /** @test */
    public function only_authenticated_user_can_create_article(): void
    {
        $data = [
            CreateRequest::TITLE => 'my article',
            CreateRequest::CONTENT => 'my article content',
        ];

        $response = $this->post(
            route('web.articles.store'),
            $data
        );

        $response->assertRedirect(route('web.welcome'));
    }

    /** @test */
    public function user_can_create_article(): void
    {
        $this->login();
        $statusRepository = new PublicationStatusRepository();
        $data = [
            CreateRequest::TITLE => 'my article',
            CreateRequest::CONTENT => 'my article content',
        ];

        $response = $this
            ->followingRedirects()
            ->post(
                route('web.articles.store'),
                $data
            );

        $this->assertStringContainsString(
            $data[CreateRequest::TITLE],
            $response->content()
        );
        $this->assertStringContainsString(
            $data[CreateRequest::CONTENT],
            $response->content()
        );
        $this->assertStringContainsString(
            $statusRepository->draft()->title,
            $response->content()
        );
    }

    public function login(): void
    {
        $this->be(User::factory()->create());
    }
}
