s<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class OwnerSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Owner Merisa Jaya',
            'email' => 'owner@merisajaya.com',
            'password' => Hash::make('owner12345'), // Ganti sandi sesuai keinginan
            'role' => 'owner',
        ]);
    }
}