<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Patient::create([
            "name" =>"Talita Bueno",
            "email" => "talita@gmail.com",
            "phone" => "12341234123",
            "birth_date" => "2001-05-10",
            "gender"=>"female",
            "allergies"=>"nenhuma"
        ]);
        \App\Models\Patient::factory()->count(9)->create();
    }
}
