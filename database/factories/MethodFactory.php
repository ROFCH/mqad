<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\;
use App\Models\Method;
use App\Models\Substance;

class MethodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Method::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'number' => $this->faker->randomNumber(),
            'substance_id' => Substance::factory(),
            'instrument_id' => ::factory(),
            'substancede' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'instriumentde' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'sort' => $this->faker->randomNumber(),
        ];
    }
}
