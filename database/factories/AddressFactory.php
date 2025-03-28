<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\;
use App\Models\Address;
use App\Models\Language;
use App\Models\ReportFormat;
use App\Models\ReportType;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'salutation' => $this->faker->regexify('[A-Za-z0-9]{80}'),
            'name' => $this->faker->name(),
            'address' => $this->faker->regexify('[A-Za-z0-9]{80}'),
            'address2' => $this->faker->secondaryAddress(),
            'postal_code' => $this->faker->postcode(),
            'city' => $this->faker->city(),
            'country' => $this->faker->country(),
            'phone' => $this->faker->phoneNumber(),
            'mail' => $this->faker->regexify('[A-Za-z0-9]{80}'),
            'contact' => $this->faker->regexify('[A-Za-z0-9]{80}'),
            'remarks' => $this->faker->regexify('[A-Za-z0-9]{200}'),
            'language_id' => Language::factory(),
            'lab_type_id' => ::factory(),
            'lab_group_id' => ::factory(),
            'qualab' => $this->faker->boolean(),
            'no_charge' => $this->faker->boolean(),
            'status_id' => ::factory(),
            'report_size_id' => $this->faker->randomNumber(),
            'invoice_name' => $this->faker->regexify('[A-Za-z0-9]{80}'),
            'invoice_address' => $this->faker->regexify('[A-Za-z0-9]{80}'),
            'invoice_address2' => $this->faker->regexify('[A-Za-z0-9]{80}'),
            'invoice_address3' => $this->faker->regexify('[A-Za-z0-9]{80}'),
            'invoice_street' => $this->faker->regexify('[A-Za-z0-9]{80}'),
            'invoice_postal_code' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'invoice_city' => $this->faker->regexify('[A-Za-z0-9]{80}'),
            'invoice_country' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'invoice_mail' => $this->faker->regexify('[A-Za-z0-9]{80}'),
            'invoice_type_id' => ::factory(),
            'no_membership' => $this->faker->boolean(),
            'simple_membership' => $this->faker->boolean(),
            'ship_format_id' => ::factory(),
            'report_type_id' => ReportType::factory(),
            'h3_education_only' => $this->faker->boolean(),
            'difficult' => $this->faker->boolean(),
            'default_password' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'online_num' => $this->faker->randomNumber(),
            'ship_type_id' => ::factory(),
            'report_format_id' => ReportFormat::factory(),
            'no_reminder' => $this->faker->boolean(),
            'temp_no_reminder' => $this->faker->boolean(),
            'qualab_num' => $this->faker->regexify('[A-Za-z0-9]{13}'),
            'sas_num' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'Swissmedic_num' => $this->faker->regexify('[A-Za-z0-9]{16}'),
        ];
    }
}
