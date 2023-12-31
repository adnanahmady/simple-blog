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

    public function restore(Article $article): void
    {
        $article->restore();
    }

    public function trash(): Collection
    {
        return $this->repository->trash(reverse: true);
    }

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

    public function update(
        Article $article,
        string $title,
        string $content,
    ): Article {
        return $this->repository->update(
            article: $article,
            title: $title,
            content: $content,
        );
    }

    public function doApproval(
        Article $article,
        bool $isApproved
    ): Article {
        $isApproved ?
            $this->repository->approve($article) :
            $this->repository->disApprove($article);

        return $article->fresh();
    }
}
