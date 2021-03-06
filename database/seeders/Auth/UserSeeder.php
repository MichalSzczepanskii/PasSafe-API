<?php

namespace Database\Seeders\Auth;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'admin@localhost',
            'password' => Hash::make('root12'),
            'encryption_key' => Str::random(32)
        ]);

        User::create([
            'email' => 'user@localhost',
            'password' => Hash::make('root12'),
            'encryption_key' => Str::random(32)
        ]);

    }
}
