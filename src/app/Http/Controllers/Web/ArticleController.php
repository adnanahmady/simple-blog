<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Articles\ApproveRequest;
use App\Http\Requests\Web\Articles\CreateRequest;
use App\Http\Requests\Web\Articles\UpdateRequest;
use App\Models\Article;
use App\Services\Web\Auth\ArticleService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ArticleController extends Controller
{
    public function show(Article $article): View
    {
        return view('articles.show', compact('article'));
    }

    public function create(): View
    {
        return view('articles.create');
    }

    public function store(
        CreateRequest $request,
        ArticleService $service
    ): RedirectResponse {
        $service->create(
            title: $request->title(),
            content: $request->content(),
            author: $request->user()
        );

        return redirect(route('web.dashboard'));
    }

    public function edit(Article $article): View
    {
        return view('articles.edit', compact('article'));
    }

    public function update(
        UpdateRequest $request,
        Article $article,
        ArticleService $service
    ): RedirectResponse {
        $service->update(
            article: $article,
            title: $request->title(),
            content: $request->content(),
        );

        return redirect(route('web.dashboard'));
    }

    public function approval(
        ApproveRequest $request,
        Article $article,
        ArticleService $service
    ) {
        $service->doApproval(
            article: $article,
            isApproved: $request->isApproved()
        );

        return redirect(route('web.dashboard'));
    }

    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        return redirect(route('web.dashboard'));
    }
}
