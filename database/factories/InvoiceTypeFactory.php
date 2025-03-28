<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\InvoiceType;

class InvoiceTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InvoiceType::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'textde' => $this->faker->word(),
            'translation_id' => $this->faker->randomNumber(),
        ];
    }
}
