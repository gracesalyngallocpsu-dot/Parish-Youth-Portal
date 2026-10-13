<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Announcement;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    }

    public function test_non_admin_user_is_forbidden(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();
    }

    public function test_admin_can_view_dashboard(): void
    {
        $this->actingAs($this->admin())
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard');
    }

    public function test_admin_can_create_an_activity(): void
    {
        $response = $this->actingAs($this->admin())->post(route('admin.activities.store'), [
            'title' => 'Barangay Outreach',
            'description' => 'A day of service in the community.',
            'location' => 'Barangay Hall',
            'starts_at' => now()->addWeek()->format('Y-m-d H:i:s'),
            'is_published' => '1',
        ]);

        $response->assertRedirect(route('admin.activities.index'));

        $this->assertDatabaseHas('activities', [
            'title' => 'Barangay Outreach',
            'slug' => 'barangay-outreach',
            'is_published' => true,
        ]);
    }

    public function test_admin_can_update_an_activity(): void
    {
        $activity = Activity::factory()->create(['title' => 'Old Title']);

        $this->actingAs($this->admin())->put(route('admin.activities.update', $activity), [
            'title' => 'New Title',
            'description' => 'Updated description.',
            'starts_at' => now()->addWeek()->format('Y-m-d H:i:s'),
            'is_published' => '1',
        ])->assertRedirect(route('admin.activities.index'));

        $this->assertDatabaseHas('activities', [
            'id' => $activity->id,
            'title' => 'New Title',
        ]);
    }

    public function test_admin_can_delete_an_activity(): void
    {
        $activity = Activity::factory()->create();

        $this->actingAs($this->admin())
            ->delete(route('admin.activities.destroy', $activity))
            ->assertRedirect(route('admin.activities.index'));

        $this->assertDatabaseMissing('activities', ['id' => $activity->id]);
    }

    public function test_admin_can_manage_announcements(): void
    {
        $this->actingAs($this->admin())->post(route('admin.announcements.store'), [
            'title' => 'Retreat Sign-ups Open',
            'body' => 'Register now for the annual youth retreat.',
            'is_published' => '1',
        ])->assertRedirect(route('admin.announcements.index'));

        $this->assertDatabaseHas('announcements', ['title' => 'Retreat Sign-ups Open']);

        $announcement = Announcement::first();

        $this->actingAs($this->admin())
            ->delete(route('admin.announcements.destroy', $announcement))
            ->assertRedirect(route('admin.announcements.index'));

        $this->assertDatabaseMissing('announcements', ['id' => $announcement->id]);
    }

    public function test_admin_can_view_registrations(): void
    {
        $registration = Registration::factory()->create(['name' => 'Mark Participant']);

        $this->actingAs($this->admin())
            ->get(route('admin.registrations.index'))
            ->assertOk()
            ->assertSee('Mark Participant');
    }
}
