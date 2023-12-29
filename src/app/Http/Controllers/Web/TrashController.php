<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Services\Web\Auth\ArticleService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TrashController extends Controller
{
    public function index(ArticleService $service): View
    {
        $articles = $service->trash();

        return view('manage.trash', compact('articles'));
    }

    public function restore(
        ArticleService $service,
        Article $article
    ): RedirectResponse {
        $service->restore($article);

        return redirect(route('web.trash'));
    }
}
