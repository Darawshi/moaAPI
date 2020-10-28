<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdvAttachSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\AdvAttach::factory(90)->create();
    }
}
