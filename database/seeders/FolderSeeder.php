<?php

namespace Database\Seeders;

use App\Models\Folder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Folder::create(['name' => 'Ogólne']);
        Folder::create(['name' => 'Bankowość']);
        Folder::create(['name' => 'Socialmedia']);
        Folder::create(['name' => 'E-maile']);
        Folder::create(['name' => 'Biznes']);
    }
}
