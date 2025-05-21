<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Plan::create([
            'name' => 'free',
            'price' => 0,
           
        ]);

        // Plan::create([
        //     'name' => 'boosted',
        //     'price' => 99,
            
        // ]);

        Plan::create([
            'name' => 'agent',
            'price' => 499,
            
         
        ]);
    }
}
