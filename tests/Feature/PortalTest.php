<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Announcement;
use App\Models\Registration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortalTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_displays_upcoming_activities_and_announcements(): void
    {
        $activity = Activity::factory()->upcoming()->create(['title' => 'Youth Camp']);
        $announcement = Announcement::factory()->create(['title' => 'Welcome Back']);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Youth Camp')
            ->assertSee('Welcome Back');
    }

    public function test_activities_index_lists_published_activities_only(): void
    {
        $published = Activity::factory()->upcoming()->create(['title' => 'Published Gathering']);
        $draft = Activity::factory()->upcoming()->create(['title' => 'Hidden Draft', 'is_published' => false]);

        $this->get(route('activities.index'))
            ->assertOk()
            ->assertSee('Published Gathering')
            ->assertDontSee('Hidden Draft');
    }

    public function test_activity_detail_page_is_displayed(): void
    {
        $activity = Activity::factory()->upcoming()->create();

        $this->get(route('activities.show', $activity))
            ->assertOk()
            ->assertSee($activity->title);
    }

    public function test_unpublished_activity_detail_returns_not_found(): void
    {
        $activity = Activity::factory()->upcoming()->create(['is_published' => false]);

        $this->get(route('activities.show', $activity))->assertNotFound();
    }

    public function test_guest_can_register_for_an_activity(): void
    {
        $activity = Activity::factory()->upcoming()->create();

        $response = $this->post(route('activities.register', $activity), [
            'name' => 'Jane Youth',
            'email' => 'jane@example.com',
            'phone' => '09171234567',
            'notes' => 'Excited to join!',
        ]);

        $response->assertRedirect(route('activities.show', $activity));

        $this->assertDatabaseHas('registrations', [
            'activity_id' => $activity->id,
            'name' => 'Jane Youth',
            'email' => 'jane@example.com',
        ]);
    }

    public function test_registration_requires_name_and_email(): void
    {
        $activity = Activity::factory()->upcoming()->create();

        $response = $this->post(route('activities.register', $activity), [
            'name' => '',
            'email' => 'not-an-email',
        ]);

        $response->assertSessionHasErrors(['name', 'email']);
        $this->assertDatabaseCount('registrations', 0);
    }

    public function test_announcement_detail_page_is_displayed(): void
    {
        $announcement = Announcement::factory()->create();

        $this->get(route('announcements.show', $announcement))
            ->assertOk()
            ->assertSee($announcement->title);
    }

    public function test_registration_factory_links_to_activity(): void
    {
        $registration = Registration::factory()->create();

        $this->assertInstanceOf(Activity::class, $registration->activity);
    }
}
