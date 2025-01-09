<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    $password = '1234567890';

    User::create([
        "name" => "John",
        "lastname" => "Doe",
        "email" => "admin@gmail.com",
        "email_verified_at" => now(),
        "user_id" => random_int(1, 10000),
        "key" => bin2hex(random_bytes(10)),
        "password" => bcrypt($password),
        "avatar" => null,
        "status" => "offline",
    ]);

    User::create([
        "name" => "Jane",
        "lastname" => "Smith",
        "email" => "adminer@gmail.com",
        "email_verified_at" => now(),
        "user_id" => random_int(1, 10000),
        "key" => bin2hex(random_bytes(10)),
        "password" => bcrypt($password),
        "avatar" => null,
        "status" => "offline",
    ]);

    echo "The password for the created users is: $password\n";
    }
}
