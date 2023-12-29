<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Auth\LoginRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(): Application|Factory|View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $attempt = Auth::attempt([
            'email' => $request->email(),
            'password' => $request->password(),
        ]);

        return $attempt ?
            redirect('/dashboard') :
            redirect(route('web.login'))->withErrors([
                LoginRequest::EMAIL => __('Email or password is wrong!'),
            ]);
    }
}
