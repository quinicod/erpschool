<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\company::class, 25)->create();
        factory(\App\grade::class, 30)->create();
        factory(\App\petition::class, 50)->create();
        factory(\App\student::class, 100)->create();
        factory(\App\study::class, 100)->create();
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
