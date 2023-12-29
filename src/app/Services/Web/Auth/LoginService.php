<?php

namespace App\Services\Web\Auth;

use App\Http\Requests\Web\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginService
{
    public function __construct(private readonly LoginRequest $request) {}

    public function attempt(): bool
    {
        return Auth::attempt([
            User::EMAIL => $this->request->email(),
            User::PASSWORD => $this->request->password(),
        ]);
    }
}
