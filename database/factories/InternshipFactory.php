<?php

namespace Database\Factories;

use App\Models\InternshipsPostStatus;
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
        // Spread internships over the last 12 months so charts show month-to-month differences
        $created = fake()->dateTimeBetween('-11 months', 'now');
        $updated = fake()->dateTimeBetween($created, 'now');
        // Ensure end_date is after created_at
        $endDate = fake()->dateTimeBetween($created, (clone $created)->modify('+3 months'));

        return [
            'job_title' => fake()->jobTitle(),
            'company' => fake()->company(),
            'location' => fake()->address(),
            'job_description' => fake()->paragraph(7),
            'requirements' => fake()->paragraph(7),
            'benefits' => fake()->paragraph(4),
            'contact_email' => fake()->email(),
            'contact_phone' => '+628' . fake()->numerify('##########'),
            'contact_name' => fake()->name(),
            'vocational_major_id' => VocationalMajor::factory(),
            'author_id' => User::factory(),
            'status_id' => InternshipsPostStatus::inRandomOrder()->value('id') ?? 1,
            'end_date' => $endDate,
            'created_at' => $created,
            'updated_at' => $updated,
        ];
    }
}
