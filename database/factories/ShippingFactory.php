<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Address;
use App\Models\Shipping;

class ShippingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Shipping::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'address_id' => Address::factory(),
            'termin' => $this->faker->randomNumber(),
            'size' => $this->faker->randomNumber(),
            'language_id' => $this->faker->randomNumber(),
            'priority' => $this->faker->randomNumber(),
            'material' => $this->faker->word(),
            'amount' => $this->faker->randomNumber(),
            'note' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'weight' => $this->faker->randomFloat(2, 0, 999999.99),
            'grp' => $this->faker->randomNumber(),
            'lot' => $this->faker->randomNumber(),
            'packing' => $this->faker->randomNumber(),
            'sort' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'year' => $this->faker->randomNumber(),
            'quarter' => $this->faker->randomNumber(),
        ];
    }
}
