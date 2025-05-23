<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate([
            'username' => 'admin',
        ], [
            'nama' => 'Administrator',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
        ]);
    }
}
