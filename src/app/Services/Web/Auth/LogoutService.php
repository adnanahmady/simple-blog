<?php

namespace App\Services\Web\Auth;

use Illuminate\Support\Facades\Auth;

class LogoutService
{
    public function logout(): void
    {
        Auth::logout();
    }
}
