<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Schedule;
use App\Models\ScheduleType;

class ScheduleTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ScheduleType::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'textde' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'translation_id' => $this->faker->randomNumber(),
            'schedule_id' => Schedule::factory(),
        ];
    }
}
