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

    protected $model = Stock::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'shop' => $this->faker->word,
            'purchase_date' => $this->faker->dateTimeBetween('-20 days', now()),
            'deadline' => $this->faker->dateTimeBetween(now(), '+1 week'),
            'name' => $this->faker->word,
            'price' => $this->faker->numberBetween(10,100),
            'number' => $this->faker->numberBetween(10,100)
        ];
    }
}
