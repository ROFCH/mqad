<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Address;
use App\Models\Schedule;

class ScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Schedule::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'address_id' => Address::factory(),
            'schedule_type_id' => $this->faker->randomNumber(),
            'year' => $this->faker->randomNumber(),
            'quarter' => $this->faker->randomNumber(),
            'remark' => $this->faker->regexify('[A-Za-z0-9]{100}'),
        ];
    }
}
