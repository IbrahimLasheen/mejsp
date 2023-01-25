<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        $this->call([
            AdminSeeder::class
        ]);
        
     //   \App\Models\Articles::factory(10)->create();
      //  \App\Models\ArticlesEn::factory(10)->create();
    }
}
