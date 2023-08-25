<?php

namespace Database\Factories;

use App\Models\MerchSale;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MerchSale>
 */
class MerchSaleFactory extends Factory
{
    protected $model = MerchSale::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_name' => $this->faker->word,
            'amount' => $this->faker->randomNumber(2),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'user_id' => User::factory(),
        ];
    }
}
