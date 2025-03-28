<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'textde' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'sample' => $this->faker->randomNumber(),
            'code' => $this->faker->regexify('[A-Za-z0-9]{4}'),
            'price' => $this->faker->word(),
            'sort' => $this->faker->randomNumber(),
            'delivery_note' => $this->faker->randomNumber(),
            'packaging' => $this->faker->word(),
            'membership' => $this->faker->randomNumber(),
            'type' => $this->faker->randomNumber(),
            'sort2' => $this->faker->randomNumber(),
            'evaluation' => $this->faker->randomNumber(),
            'sort3' => $this->faker->randomNumber(),
            'size' => $this->faker->randomNumber(),
            'weight' => $this->faker->word(),
            'translation_id' => $this->faker->randomNumber(),
            'matrix' => $this->faker->regexify('[A-Za-z0-9]{6}'),
            'infectious' => $this->faker->boolean(),
            'active' => $this->faker->boolean(),
            'volume' => $this->faker->regexify('[A-Za-z0-9]{10}'),
        ];
    }
}
