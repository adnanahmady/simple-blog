<?php

namespace App\Services\Web\Auth;

use App\Models\Article;
use App\Models\User;
use App\Repositories\ArticleRepository;
use Illuminate\Database\Eloquent\Collection;

class ArticleService
{
    public function __construct(
        private readonly ArticleRepository $repository
    ) {}

    public function all(): Collection
    {
        return $this->repository->get(reverse: true);
    }

    public function create(
        string $title,
        string $content,
        User $author,
    ): Article {
        return $this->repository->create(
            title: $title,
            content: $content,
            author: $author,
        );
    }
}
