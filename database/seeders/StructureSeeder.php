<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = ['Peito', 'Costas', 'Bíceps', 'Tríceps', 'Ombro', 'Quadríceps', 'Posterior', 'Glúteos', 'Panturrilha', 'Abdômen'];

        foreach ($groups as $group) {
            \App\Models\MuscleGroup::create(['muscle_group' => $group]);
        }

        $meals = ['Café', 'Lanche Manhã', 'Almoço', 'Lanche Tarde', 'Jantar', 'Ceia', 'Pré-Treino', 'Pós-Treino', 'Livre', 'Extra'];

        foreach ($meals as $meal) {
            \App\Models\Meal::create(['name' => $meal]);
        }

        $types = ['Hipertrofia', 'Emagrecimento', 'Resistência', 'Funcional', 'Reabilitação', 'Iniciante', 'Intermediário', 'Avançado', 'Cardio', 'Força'];

        foreach ($types as $type) {
            \App\Models\WorkoutType::create(['workout_type' => $type]);
        }
    }
}
