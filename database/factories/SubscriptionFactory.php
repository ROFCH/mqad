<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\;
use App\Models\Address;
use App\Models\Subscription;

class SubscriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subscription::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'address_id' => Address::factory(),
            'product_id' => ::factory(),
            'sample_quantity' => $this->faker->randomNumber(),
            'inscription_date' => $this->faker->date(),
            'start_year' => $this->faker->randomNumber(),
            'start_quarter' => $this->faker->randomNumber(),
            'termination_date' => $this->faker->date(),
            'stop_year' => $this->faker->randomNumber(),
            'stop_quarter' => $this->faker->randomNumber(),
            'free' => $this->faker->sha256(),
        ];
    }
}
