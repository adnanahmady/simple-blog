<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Auth\LoginRequest;
use App\Services\Web\Auth\LoginService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    public function index(): Application|Factory|View
    {
        return view('auth.login');
    }

    public function store(LoginService $service): RedirectResponse
    {
        return $service->attempt() ?
            redirect('/dashboard') :
            redirect(route('web.login'))->withErrors([
                LoginRequest::EMAIL => __('Email or password is wrong!'),
            ]);
    }
}
