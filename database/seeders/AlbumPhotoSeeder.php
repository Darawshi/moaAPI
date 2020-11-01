<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AlbumPhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       \App\Models\AlbumPhoto::factory(90)->create();
    }
}
