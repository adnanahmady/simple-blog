<?php

namespace App\Services\Web\Auth;

use App\Repositories\ArticleRepository;
use Illuminate\Database\Eloquent\Collection;

class ArticleService
{
    public function __construct(
        private readonly ArticleRepository $repository
    ) {}

    public function all(): Collection
    {
        return $this->repository->get();
    }
}
