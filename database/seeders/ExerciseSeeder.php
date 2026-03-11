<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\MuscleGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mg = MuscleGroup::query()->pluck('id', 'muscle_group');

        $exercisesByGroup = [
            'Peito' => [
                ['Supino reto com barra', 'https://www.youtube.com/results?search_query=supino+reto+com+barra'],
                ['Supino inclinado com halteres', 'https://www.youtube.com/results?search_query=supino+inclinado+com+halteres'],
                ['Supino declinado com barra', 'https://www.youtube.com/results?search_query=supino+declinado+com+barra'],
                ['Crucifixo com halteres', 'https://www.youtube.com/results?search_query=crucifixo+com+halteres'],
                ['Crossover na polia', 'https://www.youtube.com/results?search_query=crossover+na+polia'],
                ['Flexão de braços', 'https://www.youtube.com/results?search_query=flexao+de+bracos'],
                ['Peck deck', 'https://www.youtube.com/results?search_query=peck+deck'],
            ],
            'Costas' => [
                ['Puxada frontal na polia', 'https://www.youtube.com/results?search_query=puxada+frontal+na+polia'],
                ['Barra fixa', 'https://www.youtube.com/results?search_query=barra+fixa'],
                ['Remada curvada com barra', 'https://www.youtube.com/results?search_query=remada+curvada+com+barra'],
                ['Remada unilateral com halter', 'https://www.youtube.com/results?search_query=remada+unilateral+com+halter'],
                ['Remada baixa na polia', 'https://www.youtube.com/results?search_query=remada+baixa+na+polia'],
                ['Pulldown pegada neutra', 'https://www.youtube.com/results?search_query=pulldown+pegada+neutra'],
                ['Levantamento terra', 'https://www.youtube.com/results?search_query=levantamento+terra'],
            ],
            'Bíceps' => [
                ['Rosca direta com barra', 'https://www.youtube.com/results?search_query=rosca+direta+com+barra'],
                ['Rosca alternada com halteres', 'https://www.youtube.com/results?search_query=rosca+alternada+com+halteres'],
                ['Rosca martelo', 'https://www.youtube.com/results?search_query=rosca+martelo'],
                ['Rosca Scott', 'https://www.youtube.com/results?search_query=rosca+scott'],
                ['Rosca concentrada', 'https://www.youtube.com/results?search_query=rosca+concentrada'],
                ['Rosca na polia baixa', 'https://www.youtube.com/results?search_query=rosca+na+polia+baixa'],
            ],
            'Tríceps' => [
                ['Tríceps pulley (corda)', 'https://www.youtube.com/results?search_query=triceps+pulley+corda'],
                ['Tríceps testa com barra', 'https://www.youtube.com/results?search_query=triceps+testa+com+barra'],
                ['Tríceps francês com halter', 'https://www.youtube.com/results?search_query=triceps+frances+com+halter'],
                ['Mergulho nas paralelas', 'https://www.youtube.com/results?search_query=mergulho+nas+paralelas'],
                ['Tríceps banco', 'https://www.youtube.com/results?search_query=triceps+banco'],
                ['Tríceps coice', 'https://www.youtube.com/results?search_query=triceps+coice'],
            ],
            'Ombro' => [
                ['Desenvolvimento militar com barra', 'https://www.youtube.com/results?search_query=desenvolvimento+militar+com+barra'],
                ['Desenvolvimento com halteres', 'https://www.youtube.com/results?search_query=desenvolvimento+com+halteres'],
                ['Elevação lateral', 'https://www.youtube.com/results?search_query=elevacao+lateral'],
                ['Elevação frontal', 'https://www.youtube.com/results?search_query=elevacao+frontal'],
                ['Crucifixo invertido', 'https://www.youtube.com/results?search_query=crucifixo+invertido'],
                ['Remada alta', 'https://www.youtube.com/results?search_query=remada+alta'],
                ['Face pull', 'https://www.youtube.com/results?search_query=face+pull'],
            ],
            'Quadríceps' => [
                ['Agachamento livre', 'https://www.youtube.com/results?search_query=agachamento+livre'],
                ['Agachamento frontal', 'https://www.youtube.com/results?search_query=agachamento+frontal'],
                ['Leg press 45', 'https://www.youtube.com/results?search_query=leg+press+45'],
                ['Cadeira extensora', 'https://www.youtube.com/results?search_query=cadeira+extensora'],
                ['Passada (afundo) com halteres', 'https://www.youtube.com/results?search_query=passada+afundo+com+halteres'],
                ['Hack squat', 'https://www.youtube.com/results?search_query=hack+squat'],
            ],
            'Posterior' => [
                ['Levantamento terra romeno (stiff)', 'https://www.youtube.com/results?search_query=levantamento+terra+romeno+stiff'],
                ['Mesa flexora', 'https://www.youtube.com/results?search_query=mesa+flexora'],
                ['Cadeira flexora', 'https://www.youtube.com/results?search_query=cadeira+flexora'],
                ['Good morning', 'https://www.youtube.com/results?search_query=good+morning+exercicio'],
                ['Ponte de glúteos (ênfase posterior)', 'https://www.youtube.com/results?search_query=ponte+de+gluteos+exercicio'],
            ],
            'Glúteos' => [
                ['Hip thrust', 'https://www.youtube.com/results?search_query=hip+thrust'],
                ['Glute bridge', 'https://www.youtube.com/results?search_query=glute+bridge'],
                ['Cadeira abdutora', 'https://www.youtube.com/results?search_query=cadeira+abdutora'],
                ['Coice no cabo (kickback)', 'https://www.youtube.com/results?search_query=coice+no+cabo+kickback'],
                ['Agachamento sumô', 'https://www.youtube.com/results?search_query=agachamento+sumo'],
            ],
            'Panturrilha' => [
                ['Elevação de panturrilha em pé', 'https://www.youtube.com/results?search_query=elevacao+de+panturrilha+em+pe'],
                ['Elevação de panturrilha sentado', 'https://www.youtube.com/results?search_query=elevacao+de+panturrilha+sentado'],
                ['Panturrilha no leg press', 'https://www.youtube.com/results?search_query=panturrilha+no+leg+press'],
                ['Panturrilha no smith', 'https://www.youtube.com/results?search_query=panturrilha+no+smith'],
            ],
            'Abdômen' => [
                ['Abdominal infra (elevação de pernas)', 'https://www.youtube.com/results?search_query=abdominal+infra+elevacao+de+pernas'],
                ['Abdominal supra', 'https://www.youtube.com/results?search_query=abdominal+supra'],
                ['Prancha', 'https://www.youtube.com/results?search_query=prancha+abdominal'],
                ['Prancha lateral', 'https://www.youtube.com/results?search_query=prancha+lateral'],
                ['Abdominal bicicleta', 'https://www.youtube.com/results?search_query=abdominal+bicicleta'],
                ['Crunch na bola suíça', 'https://www.youtube.com/results?search_query=crunch+na+bola+suica'],
            ],
        ];

        foreach ($exercisesByGroup as $groupName => $list) {
            $groupId = $mg[$groupName] ?? null;

            if (!$groupId) {
                continue;
            }

            foreach ($list as [$name, $link]) {
                Exercise::updateOrCreate(
                    [
                        'muscle_group_id' => $groupId,
                        'exercise' => $name,
                    ],
                    [
                        'link_exercise' => $link,
                    ]
                );
            }
        }
    }
}
