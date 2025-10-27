<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

    \App\Models\User::factory()->create([
        'first_name' => 'کاربر شماره ۱',
        'last_name' => 'محمدی',
        'mobile' => '09120000001',
        'password' => \Illuminate\Support\Facades\Hash::make('password'),
    ]);

    \App\Models\User::factory()->create([
        'first_name' => 'کاربر شماره ۲',
        'last_name' => 'سعیدی',
        'mobile' => '09120000002',
        'password' => \Illuminate\Support\Facades\Hash::make('password'),
    ]);

    \App\Models\User::factory()->create([
        'first_name' => 'کاربر شماره ۳',
        'last_name' => 'احمدی',
        'mobile' => '09120000003',
        'password' => \Illuminate\Support\Facades\Hash::make('password'),
    ]);
    }
}
