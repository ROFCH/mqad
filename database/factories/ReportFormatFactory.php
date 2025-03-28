<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ReportFormat;

class ReportFormatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ReportFormat::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'textde' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'translation_id' => $this->faker->randomNumber(),
        ];
    }
}
