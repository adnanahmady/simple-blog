<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class ArticleRepository
{
    public function __construct(
        private readonly PublicationStatusRepository $statusService
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
            Article::STATUS => $this->statusService->draft()->id(),
        ]);
    }
}
