<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Adv::factory(200)->create();
    }
}
