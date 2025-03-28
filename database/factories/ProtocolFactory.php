<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\;
use App\Models\Address;
use App\Models\Protocol;

class ProtocolFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Protocol::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'address_id' => Address::factory(),
            'method_id' => ::factory(),
            'unit_id' => $this->faker->randomNumber(),
            'device_id' => $this->faker->randomNumber(),
            'device_num' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'Serialnumber' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'department' => $this->faker->randomNumber(),
            'start_date' => $this->faker->dateTime(),
            'start_year' => $this->faker->randomNumber(),
            'start_quarter' => $this->faker->randomNumber(),
            'stop_date' => $this->faker->dateTime(),
            'stop_year' => $this->faker->randomNumber(),
            'stop_quarter' => $this->faker->randomNumber(),
        ];
    }
}
