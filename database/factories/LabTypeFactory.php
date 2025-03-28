<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\LabType;

class LabTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LabType::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'textde' => $this->faker->word(),
            'translation_id' => $this->faker->randomNumber(),
            'complexity' => $this->faker->randomNumber(),
        ];
    }
}
