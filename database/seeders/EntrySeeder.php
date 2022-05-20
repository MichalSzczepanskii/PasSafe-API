<?php

namespace Database\Seeders;

use App\Models\Entry;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Entry::create([
            'name' => 'Allegro',
            'login' => 'test@gmail.com',
            'password' => 'test',
            'site' => 'https://allegro.com',
            'user_id' => User::where('email', 'admin@localhost')->first()->id,
            'folder_id' => Folder::where('id', 1)->first()->id,
        ]);

        Entry::create([
            'name' => 'Faceebok',
            'login' => 'test@gmail.com',
            'password' => 'test',
            'site' => 'https://allegro.com',
            'user_id' => User::where('email', 'admin@localhost')->first()->id,
            'folder_id' => Folder::where('id', 3)->first()->id,
            'description' => 'testowy opis',
        ]);
    }
}
