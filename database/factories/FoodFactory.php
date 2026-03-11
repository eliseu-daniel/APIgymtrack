<?php

namespace Database\Factories;

use App\Models\Food;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Food>
 */
class FoodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Food::class;

    public function definition(): array
    {
        $foods = [
            // básicos
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

            // proteínas
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

            // laticínios
            'Leite integral',
            'Leite desnatado',
            'Requeijão',
            'Manteiga',
            'Margarina',

            // legumes e verduras
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

            // frutas
            'Banana',
            'Maçã',
            'Laranja',
            'Mamão',
            'Melancia',
            'Abacaxi',
            'Uva',
            'Limão',

            // grãos e cereais
            'Aveia',
            'Granola',
            'Pão francês',
            'Pão integral',
            'Tapioca (goma)',
            'Cuscuz (flocão de milho)',

            // bebidas/itens comuns
            'Café',
            'Chá',
            'Achocolatado em pó',
            'Mel',

            // oleaginosas (EVITAR: castanhas e coco cru — mas deixei fora)
            'Amendoim',
            'Pasta de amendoim',

            // outros
            'Molho de tomate',
            'Milho (lata)',
            'Ervilha (lata)',
            'Atum ralado',
            'Salsicha',
        ];

        return [
            // se tiver coluna "unit" ou algo assim, dá pra expandir depois
            'name' => fake()->randomElement($foods),
        ];
    }
}
