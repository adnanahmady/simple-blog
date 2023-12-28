<?php

namespace Database\Seeders;

use App\Repositories\AdminRepository;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    private array $admins = [
        [
            'name' => 'admin',
            'email' => 'admin@blog.com',
            'password' => 'secret',
        ],
        [
            'name' => 'adnan',
            'email' => 'adnan@blog.dev',
            'password' => 'secret',
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(AdminRepository $repository): void
    {
        foreach ($this->admins as $admin) {
            $repository->create(...$admin);
        }
    }
}
