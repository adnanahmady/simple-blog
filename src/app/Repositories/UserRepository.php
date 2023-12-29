<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function create(
        string $name,
        string $email,
        string $password
    ): User {
        return User::create([
            User::NAME => $name,
            User::EMAIL => $email,
            User::PASSWORD => $password,
            User::EMAIL_VERIFIED_AT => now(),
            User::IS_ADMIN => false,
        ]);
    }
}
