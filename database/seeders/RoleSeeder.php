<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name_en' =>'Admin' ,'name_ar' =>'ادمن']);
        Role::create(['name_en' =>'Publisher' ,'name_ar' =>'ناشر']);
        Role::create(['name_en' =>'Viewer' ,'name_ar' =>'مشاهد']);
    }
}
