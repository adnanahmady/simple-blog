<?php

namespace App\Repositories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;

class ArticleRepository
{
    public function get(): Collection
    {
        return Article::all();
    }
}
