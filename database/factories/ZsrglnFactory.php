<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Address;
use App\Models\Zsrgln;

class ZsrglnFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Zsrgln::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'address_id' => Address::factory(),
            'type' => $this->faker->regexify('[A-Za-z0-9]{24}'),
            'name' => $this->faker->name(),
            'surname' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'addidional' => $this->faker->regexify('[A-Za-z0-9]{30}'),
            'postalnumber' => $this->faker->regexify('[A-Za-z0-9]{6}'),
            'place' => $this->faker->regexify('[A-Za-z0-9]{24}'),
            'zsr' => $this->faker->regexify('[A-Za-z0-9]{16}'),
            'gln' => $this->faker->regexify('[A-Za-z0-9]{14}'),
            'from_year' => $this->faker->randomNumber(),
            'till_year' => $this->faker->randomNumber(),
        ];
    }
}
