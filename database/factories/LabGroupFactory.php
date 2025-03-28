<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\LabGroup;

class LabGroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LabGroup::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'textde' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'remarks' => $this->faker->regexify('[A-Za-z0-9]{100}'),
        ];
    }
}
