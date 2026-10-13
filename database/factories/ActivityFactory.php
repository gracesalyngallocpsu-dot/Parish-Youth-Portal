<?php

namespace Database\Factories;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Activity>
 */
class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    public function definition(): array
    {
        $title = fake()->unique()->sentence(3);
        $starts = fake()->dateTimeBetween('-1 month', '+2 months');

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => fake()->paragraphs(3, true),
            'location' => fake()->randomElement([
                'Parish Hall',
                'Main Church',
                'Youth Center',
                'Community Grounds',
                null,
            ]),
            'starts_at' => $starts,
            'ends_at' => (clone $starts)->modify('+2 hours'),
            'is_published' => true,
            'image_path' => null,
        ];
    }

    public function past(): static
    {
        return $this->state(fn () => [
            'starts_at' => fake()->dateTimeBetween('-3 months', '-1 week'),
        ]);
    }

    public function upcoming(): static
    {
        return $this->state(fn () => [
            'starts_at' => fake()->dateTimeBetween('+1 week', '+2 months'),
        ]);
    }
}
