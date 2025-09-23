<?php

namespace Database\Factories;

use App\Models\InternshipsPostStatus;
use App\Models\JobCategory;
use App\Models\User;
use App\Models\VocationalMajor;
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
            'job_description' => fake()->paragraph(7),
            'requirements' => fake()->paragraph(7),
            'benefits' => fake()->paragraph(4   ),
            'contact_email' => fake()->email(),
            'contact_phone' => fake()->phoneNumber(),
            'contact_name' => fake()->name(),
            'vocational_major_id' => VocationalMajor::factory(),
            'author_id' => User::factory(),
            'job_category_id' => JobCategory::factory(),
            'status_id' => InternshipsPostStatus::inRandomOrder()->value('id') ?? 1,
            'end_date' => fake()->dateTimeBetween('+1 week', '+1 month'),
        ];
    }
}
