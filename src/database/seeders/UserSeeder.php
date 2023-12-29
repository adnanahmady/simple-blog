<?php

namespace Database\Seeders;

use App\Repositories\UserRepository;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    private array $users = [
        [
            'name' => 'john',
            'email' => 'john@blog.com',
            'password' => 'secret',
        ],
        [
            'name' => 'jain',
            'email' => 'jain@blog.dev',
            'password' => 'secret',
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(UserRepository $repository): void
    {
        foreach ($this->users as $user) {
            $repository->create(...$user);
        }
    }
}
