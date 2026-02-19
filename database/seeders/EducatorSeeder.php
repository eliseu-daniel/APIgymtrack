<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EducatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Educator::create([
            'name' => 'Educator Test',
            'email' => 'educator@test.com',
            'password' => bcrypt('123456'),
            'phone' => '14999999999',
            'is_active' => true,
        ]);
        \App\Models\Educator::factory()->count(9)->create();
    }
}
