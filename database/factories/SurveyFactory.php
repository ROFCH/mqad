<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Survey;

class SurveyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Survey::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'year' => $this->faker->randomNumber(),
            'quarter' => $this->faker->randomNumber(),
            'shipping' => $this->faker->dateTime(),
            'closing' => $this->faker->dateTime(),
            'replacementdate' => $this->faker->dateTime(),
            'end' => $this->faker->dateTime(),
            'status' => $this->faker->randomNumber(),
            'remark' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'online_id' => $this->faker->randomNumber(),
        ];
    }
}
