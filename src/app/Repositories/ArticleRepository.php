<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class ArticleRepository
{
    public function __construct(
        private readonly PublicationStatusRepository $statusRepository
    ) {}

    public function get(bool $reverse = false): Collection
    {
        return $reverse ? Article::query()
            ->latest(Article::UPDATED_AT)
            ->get() : Article::all();
    }

    public function create(
        string $title,
        string $content,
        User $author,
    ): Article {
        return Article::create([
            Article::TITLE => $title,
            Article::CONTENT => $content,
            Article::AUTHOR => $author->id(),
            Article::STATUS => $this->statusRepository->draft()->id(),
        ]);
    }

    public function update(
        Article $article,
        string $title,
        string $content,
    ): Article {
        Article::query()
            ->where(Article::ID, $article->id())
            ->update([
                Article::TITLE => $title,
                Article::CONTENT => $content,
            ]);

        return $article->fresh();
    }

    public function approve(Article $article): bool
    {
        return $article->update([
            Article::STATUS => $this->statusRepository->publish()->id(),
            Article::PUBLICATION_DATE => now(),
        ]);
    }

    public function disApprove(Article $article): bool
    {
        return $article->update([
            Article::STATUS => $this->statusRepository->draft()->id(),
            Article::PUBLICATION_DATE => null,
        ]);
    }
}
