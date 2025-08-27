<?php

namespace Database\Factories;

use App\Models\JobCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Internship>
 */
class InternshipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'job_title' => fake()->jobTitle(),
            'company' => fake()->company(),
            'location' => fake()->address(),
            'job_description' => fake()->paragraph(2),
            'requirements' => fake()->paragraph(2),
            'benefits' => fake()->paragraph(2),
            'contact_email' => fake()->email(),
            'contact_phone' => fake()->phoneNumber(),
            'contact_name' => fake()->name(),
            'author_id' => User::factory(),
            'job_category_id' => JobCategory::factory(),
            'end_date' => fake()->dateTimeBetween('+1 week', '+1 month'),
        ];
    }
}
