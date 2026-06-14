<?php

namespace Database\Seeders;

use App\Models\Food;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    public function run(): void
    {
        $foods = [
            'Arroz',
            'Feijão',
            'Macarrão',
            'Farinha de mandioca',
            'Farinha de trigo',
            'Açúcar',
            'Sal',
            'Óleo de soja',
            'Azeite',
            'Vinagre',

            'Frango (peito)',
            'Frango (coxa/sobrecoxa)',
            'Carne moída',
            'Acém',
            'Sardinha em lata',
            'Atum em lata',
            'Ovo',
            'Queijo muçarela',
            'Queijo minas',
            'Iogurte natural',

            'Leite integral',
            'Leite desnatado',
            'Requeijão',
            'Manteiga',
            'Margarina',

            'Alface',
            'Tomate',
            'Cebola',
            'Alho',
            'Batata',
            'Batata-doce',
            'Mandioca (aipim)',
            'Abobrinha',
            'Chuchu',
            'Beterraba',
            'Couve',
            'Brócolis',
            'Espinafre',
            'Pepino',

            'Banana',
            'Maçã',
            'Laranja',
            'Mamão',
            'Melancia',
            'Abacaxi',
            'Uva',
            'Limão',

            'Aveia',
            'Granola',
            'Pão francês',
            'Pão integral',
            'Tapioca (goma)',
            'Cuscuz (flocão de milho)',

            'Café',
            'Chá',
            'Achocolatado em pó',
            'Mel',

            'Amendoim',
            'Pasta de amendoim',

            'Molho de tomate',
            'Milho (lata)',
            'Ervilha (lata)',
            'Atum ralado',
            'Salsicha',
        ];

        foreach ($foods as $food) {
            Food::create([
                'name' => $food,
            ]);
        }
    }
}
