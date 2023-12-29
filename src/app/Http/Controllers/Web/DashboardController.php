<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\Web\Auth\ArticleService;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(ArticleService $service): View
    {
        return view('dashboard', [
            'articles' => $service->all(),
        ]);
    }
}
