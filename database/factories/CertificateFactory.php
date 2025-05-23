<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Address;
use App\Models\Certificate;

class CertificateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Certificate::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'address_id' => Address::factory(),
            'substance_id' => $this->faker->randomNumber(),
            'success' => $this->faker->randomNumber(),
            'participation' => $this->faker->randomNumber(),
            'evaluation' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'year' => $this->faker->randomNumber(),
        ];
    }
}
