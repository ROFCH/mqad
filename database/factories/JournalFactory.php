<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\;
use App\Models\Address;
use App\Models\Journal;

class JournalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Journal::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'address_id' => Address::factory(),
            'journal_type_id' => ::factory(),
            'sample' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'remark' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'year' => $this->faker->randomNumber(),
            'quarter' => $this->faker->randomNumber(),
        ];
    }
}
