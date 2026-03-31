<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exercise>
 */
class ExerciseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $exerciseData = $this->getExercisesList()[array_rand($this->getExercisesList())];

        $muscleGroup = \App\Models\MuscleGroup::where('muscle_group', $exerciseData['group'])->first();

        return [
            'muscle_group_id' => $muscleGroup?->id ?? \App\Models\MuscleGroup::inRandomOrder()->first()->id,
            'exercise' => $exerciseData['name'],
            'link_exercise' => $exerciseData['link'],
        ];
    }

    /**
     * Return all exercises from the seeder.
     *
     * @return array<int, array{group:string,name:string,link:string}>
     */
    private function getExercisesList(): array
    {
        return [
            ['group' => 'Peito', 'name' => 'Supino reto com barra', 'link' => 'https://www.youtube.com/results?search_query=supino+reto+com+barra'],
            ['group' => 'Peito', 'name' => 'Supino inclinado com halteres', 'link' => 'https://www.youtube.com/results?search_query=supino+inclinado+com+halteres'],
            ['group' => 'Peito', 'name' => 'Supino declinado com barra', 'link' => 'https://www.youtube.com/results?search_query=supino+declinado+com+barra'],
            ['group' => 'Peito', 'name' => 'Crucifixo com halteres', 'link' => 'https://www.youtube.com/results?search_query=crucifixo+com+halteres'],
            ['group' => 'Peito', 'name' => 'Crossover na polia', 'link' => 'https://www.youtube.com/results?search_query=crossover+na+polia'],
            ['group' => 'Peito', 'name' => 'Flexão de braços', 'link' => 'https://www.youtube.com/results?search_query=flexao+de+bracos'],
            ['group' => 'Peito', 'name' => 'Peck deck', 'link' => 'https://www.youtube.com/results?search_query=peck+deck'],
            ['group' => 'Costas', 'name' => 'Puxada frontal na polia', 'link' => 'https://www.youtube.com/results?search_query=puxada+frontal+na+polia'],
            ['group' => 'Costas', 'name' => 'Barra fixa', 'link' => 'https://www.youtube.com/results?search_query=barra+fixa'],
            ['group' => 'Costas', 'name' => 'Remada curvada com barra', 'link' => 'https://www.youtube.com/results?search_query=remada+curvada+com+barra'],
            ['group' => 'Costas', 'name' => 'Remada unilateral com halter', 'link' => 'https://www.youtube.com/results?search_query=remada+unilateral+com+halter'],
            ['group' => 'Costas', 'name' => 'Remada baixa na polia', 'link' => 'https://www.youtube.com/results?search_query=remada+baixa+na+polia'],
            ['group' => 'Costas', 'name' => 'Pulldown pegada neutra', 'link' => 'https://www.youtube.com/results?search_query=pulldown+pegada+neutra'],
            ['group' => 'Costas', 'name' => 'Levantamento terra', 'link' => 'https://www.youtube.com/results?search_query=levantamento+terra'],
            ['group' => 'Bíceps', 'name' => 'Rosca direta com barra', 'link' => 'https://www.youtube.com/results?search_query=rosca+direta+com+barra'],
            ['group' => 'Bíceps', 'name' => 'Rosca alternada com halteres', 'link' => 'https://www.youtube.com/results?search_query=rosca+alternada+com+halteres'],
            ['group' => 'Bíceps', 'name' => 'Rosca martelo', 'link' => 'https://www.youtube.com/results?search_query=rosca+martelo'],
            ['group' => 'Bíceps', 'name' => 'Rosca Scott', 'link' => 'https://www.youtube.com/results?search_query=rosca+scott'],
            ['group' => 'Bíceps', 'name' => 'Rosca concentrada', 'link' => 'https://www.youtube.com/results?search_query=rosca+concentrada'],
            ['group' => 'Bíceps', 'name' => 'Rosca na polia baixa', 'link' => 'https://www.youtube.com/results?search_query=rosca+na+polia+baixa'],
            ['group' => 'Tríceps', 'name' => 'Tríceps pulley (corda)', 'link' => 'https://www.youtube.com/results?search_query=triceps+pulley+corda'],
            ['group' => 'Tríceps', 'name' => 'Tríceps testa com barra', 'link' => 'https://www.youtube.com/results?search_query=triceps+testa+com+barra'],
            ['group' => 'Tríceps', 'name' => 'Tríceps francês com halter', 'link' => 'https://www.youtube.com/results?search_query=triceps+frances+com+halter'],
            ['group' => 'Tríceps', 'name' => 'Mergulho nas paralelas', 'link' => 'https://www.youtube.com/results?search_query=mergulho+nas+paralelas'],
            ['group' => 'Tríceps', 'name' => 'Tríceps banco', 'link' => 'https://www.youtube.com/results?search_query=triceps+banco'],
            ['group' => 'Tríceps', 'name' => 'Tríceps coice', 'link' => 'https://www.youtube.com/results?search_query=triceps+coice'],
            ['group' => 'Ombro', 'name' => 'Desenvolvimento militar com barra', 'link' => 'https://www.youtube.com/results?search_query=desenvolvimento+militar+com+barra'],
            ['group' => 'Ombro', 'name' => 'Desenvolvimento com halteres', 'link' => 'https://www.youtube.com/results?search_query=desenvolvimento+com+halteres'],
            ['group' => 'Ombro', 'name' => 'Elevação lateral', 'link' => 'https://www.youtube.com/results?search_query=elevacao+lateral'],
            ['group' => 'Ombro', 'name' => 'Elevação frontal', 'link' => 'https://www.youtube.com/results?search_query=elevacao+frontal'],
            ['group' => 'Ombro', 'name' => 'Crucifixo invertido', 'link' => 'https://www.youtube.com/results?search_query=crucifixo+invertido'],
            ['group' => 'Ombro', 'name' => 'Remada alta', 'link' => 'https://www.youtube.com/results?search_query=remada+alta'],
            ['group' => 'Ombro', 'name' => 'Face pull', 'link' => 'https://www.youtube.com/results?search_query=face+pull'],
            ['group' => 'Quadríceps', 'name' => 'Agachamento livre', 'link' => 'https://www.youtube.com/results?search_query=agachamento+livre'],
            ['group' => 'Quadríceps', 'name' => 'Agachamento frontal', 'link' => 'https://www.youtube.com/results?search_query=agachamento+frontal'],
            ['group' => 'Quadríceps', 'name' => 'Leg press 45', 'link' => 'https://www.youtube.com/results?search_query=leg+press+45'],
            ['group' => 'Quadríceps', 'name' => 'Cadeira extensora', 'link' => 'https://www.youtube.com/results?search_query=cadeira+extensora'],
            ['group' => 'Quadríceps', 'name' => 'Passada (afundo) com halteres', 'link' => 'https://www.youtube.com/results?search_query=passada+afundo+com+halteres'],
            ['group' => 'Quadríceps', 'name' => 'Hack squat', 'link' => 'https://www.youtube.com/results?search_query=hack+squat'],
            ['group' => 'Posterior', 'name' => 'Levantamento terra romeno (stiff)', 'link' => 'https://www.youtube.com/results?search_query=levantamento+terra+romeno+stiff'],
            ['group' => 'Posterior', 'name' => 'Mesa flexora', 'link' => 'https://www.youtube.com/results?search_query=mesa+flexora'],
            ['group' => 'Posterior', 'name' => 'Cadeira flexora', 'link' => 'https://www.youtube.com/results?search_query=cadeira+flexora'],
            ['group' => 'Posterior', 'name' => 'Good morning', 'link' => 'https://www.youtube.com/results?search_query=good+morning+exercicio'],
            ['group' => 'Posterior', 'name' => 'Ponte de glúteos (ênfase posterior)', 'link' => 'https://www.youtube.com/results?search_query=ponte+de+gluteos+exercicio'],
            ['group' => 'Glúteos', 'name' => 'Hip thrust', 'link' => 'https://www.youtube.com/results?search_query=hip+thrust'],
            ['group' => 'Glúteos', 'name' => 'Glute bridge', 'link' => 'https://www.youtube.com/results?search_query=glute+bridge'],
            ['group' => 'Glúteos', 'name' => 'Cadeira abdutora', 'link' => 'https://www.youtube.com/results?search_query=cadeira+abdutora'],
            ['group' => 'Glúteos', 'name' => 'Coice no cabo (kickback)', 'link' => 'https://www.youtube.com/results?search_query=coice+no+cabo+kickback'],
            ['group' => 'Glúteos', 'name' => 'Agachamento sumô', 'link' => 'https://www.youtube.com/results?search_query=agachamento+sumo'],
            ['group' => 'Panturrilha', 'name' => 'Elevação de panturrilha em pé', 'link' => 'https://www.youtube.com/results?search_query=elevacao+de+panturrilha+em+pe'],
            ['group' => 'Panturrilha', 'name' => 'Elevação de panturrilha sentado', 'link' => 'https://www.youtube.com/results?search_query=elevacao+de+panturrilha+sentado'],
            ['group' => 'Panturrilha', 'name' => 'Panturrilha no leg press', 'link' => 'https://www.youtube.com/results?search_query=panturrilha+no+leg+press'],
            ['group' => 'Panturrilha', 'name' => 'Panturrilha no smith', 'link' => 'https://www.youtube.com/results?search_query=panturrilha+no+smith'],
            ['group' => 'Abdômen', 'name' => 'Abdominal infra (elevação de pernas)', 'link' => 'https://www.youtube.com/results?search_query=abdominal+infra+elevacao+de+pernas'],
            ['group' => 'Abdômen', 'name' => 'Abdominal supra', 'link' => 'https://www.youtube.com/results?search_query=abdominal+supra'],
            ['group' => 'Abdômen', 'name' => 'Prancha', 'link' => 'https://www.youtube.com/results?search_query=prancha+abdominal'],
            ['group' => 'Abdômen', 'name' => 'Prancha lateral', 'link' => 'https://www.youtube.com/results?search_query=prancha+lateral'],
            ['group' => 'Abdômen', 'name' => 'Abdominal bicicleta', 'link' => 'https://www.youtube.com/results?search_query=abdominal+bicicleta'],
            ['group' => 'Abdômen', 'name' => 'Crunch na bola suíça', 'link' => 'https://www.youtube.com/results?search_query=crunch+na+bola+suica'],
        ];
    }
}
