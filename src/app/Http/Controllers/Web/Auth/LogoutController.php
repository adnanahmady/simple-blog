<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Services\Web\Auth\LogoutService;
use Illuminate\Http\RedirectResponse;

class LogoutController extends Controller
{
    public function store(LogoutService $service): RedirectResponse
    {
        $service->logout();

        return redirect(route('web.login'));
    }
}
