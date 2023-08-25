<?php

namespace Database\Factories;

use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscriber>
 */
class SubscriberFactory extends Factory
{
    protected $model = Subscriber::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->userName,
            'subscription_tier' => $this->faker->randomElement(['Tier1', 'Tier2', 'Tier3']),
            'user_id' => User::factory(),
        ];
    }
}
