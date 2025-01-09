<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
        "name" => "Adminer",
        "lastname" => "adminer",
        "email" => "admin@gmail.com",
        "email_verified_at" => "admin@gmail.com",
        "password" => "1234567890",
        ];
    }
}
