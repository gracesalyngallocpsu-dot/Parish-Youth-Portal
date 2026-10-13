<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Announcement;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'name' => 'Parish Admin',
            'email' => 'admin@parish.test',
            'password' => 'password',
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        $upcoming = Activity::factory()->count(6)->upcoming()->create();
        $past = Activity::factory()->count(4)->past()->create();

        Activity::factory()->create([
            'title' => 'Draft Retreat Planning',
            'slug' => 'draft-retreat-planning',
            'is_published' => false,
            'starts_at' => now()->addMonth(),
        ]);

        Announcement::factory()->count(6)->create();

        foreach ($upcoming->merge($past) as $activity) {
            Registration::factory()->count(random_int(2, 8))->create([
                'activity_id' => $activity->id,
            ]);
        }
    }
}
