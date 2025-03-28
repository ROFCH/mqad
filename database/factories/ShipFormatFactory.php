<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ShipFormat;

class ShipFormatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShipFormat::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'textde' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'translation_id' => $this->faker->randomNumber(),
            'maxweight' => $this->faker->randomNumber(),
            'maxnumber' => $this->faker->randomNumber(),
            'price' => $this->faker->randomFloat(2, 0, 999999.99),
            'lot' => $this->faker->randomNumber(),
            'remark' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'nextformat' => $this->faker->randomNumber(),
        ];
    }
}
