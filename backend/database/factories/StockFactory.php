<?php

namespace Database\Factories;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Stock::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => \App\Models\Stock::factory(),
            'shop' => $this->faker->word,
            'purchase_date' => $this->faker->date($format=‘Y-m-d’,$max=‘now’),
            'deadline' => $this->faker->date($format=‘Y-m-d’,$max=‘now’),
            'name' => $this->faker->word,
            'price' => $this->faker->numberBetween(10,100),
            'number' => $this->faker->numberBetween(10,100)
        ];
    }
}
