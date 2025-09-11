<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\EventOccurrence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\View;
use Tests\TestCase;

class EventControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function validPayload(array $overrides = []): array
    {
        return array_merge([
            'event_name' => 'Sample Event',
            'event_description' => 'An example event',
            'event_type' => 'seminar',
            'status' => 'upcoming',
            'start_date' => now()->toDateString(),
            'start_time' => '10:00:00',
            'end_date' => now()->addDay()->toDateString(),
            'end_time' => '12:00:00',
            'location' => 'Main Hall',
            'number_Volunteer_needed' => 5,
            'repeat' => 'once',
        ], $overrides);
    }

    public function test_index_displays_events_and_metrics()
    {
        Event::factory()->count(3)->create();

        $response = $this->get(route('admin.events.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.events.index');
        $response->assertViewHasAll(['events', 'totalEvents', 'upcomingEvents']);
    }

    public function test_index_ajax_returns_partial_list()
    {
        Event::factory()->count(2)->create();

        // Ensure partial view exists by faking render output
        View::shouldReceive('make')->andReturnSelf();
        View::shouldReceive('with')->andReturnSelf();
        View::shouldReceive('render')->andReturn('<div>list</div>');

        $response = $this->get(route('admin.events.index'), ['X-Requested-With' => 'XMLHttpRequest']);

        $response->assertOk();
        $response->assertJsonStructure(['list']);
    }

    public function test_show_displays_event_and_occurrences()
    {
        $event = Event::factory()->create();
        EventOccurrence::factory()->count(2)->create(['event_id' => $event->id]);

        $response = $this->get(route('admin.events.show', $event->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.events.show');
        $response->assertViewHasAll(['event', 'eventOccurrences']);
    }

    public function test_show_404_when_event_missing()
    {
        $response = $this->get(route('admin.events.show', 99999));
        $response->assertNotFound();
    }

    public function test_create_displays_form_and_existing_events()
    {
        Event::factory()->count(2)->create();
        $response = $this->get(route('admin.events.create'));
        $response->assertOk();
        $response->assertViewIs('admin.events.create');
        $response->assertViewHas('existingEvents');
    }

    public function test_create_ajax_returns_existing_events_json()
    {
        Event::factory()->count(2)->create();
        $response = $this->get(route('admin.events.create'), ['X-Requested-With' => 'XMLHttpRequest']);
        $response->assertOk();
        $response->assertJsonStructure(['data']);
    }

    public function test_store_creates_event_and_redirects_success()
    {
        $payload = $this->validPayload();
        $response = $this->post(route('admin.events.store'), $payload);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('events', ['event_name' => $payload['event_name']]);
    }

    public function test_store_validation_errors()
    {
        $payload = $this->validPayload(['event_name' => '']);
        $response = $this->from(route('admin.events.create'))
            ->post(route('admin.events.store'), $payload);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['event_name']);
    }

    // Exception path for store() requires refactor to inject dependency for mocking.

    public function test_edit_displays_event()
    {
        $event = Event::factory()->create();
        $response = $this->get(route('admin.events.edit', $event->id));
        $response->assertOk();
        $response->assertViewIs('admin.events.edit');
        $response->assertViewHas('event');
    }

    public function test_edit_404_when_missing()
    {
        $response = $this->get(route('admin.events.edit', 99999));
        $response->assertNotFound();
    }

    public function test_update_success()
    {
        $event = Event::factory()->create();
        $payload = $this->validPayload(['event_name' => 'Updated Name']);

        $response = $this->put(route('admin.events.update', $event->id), $payload);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('events', ['id' => $event->id, 'event_name' => 'Updated Name']);
    }

    public function test_update_validation_error()
    {
        $event = Event::factory()->create();
        $payload = $this->validPayload(['event_name' => '']);

        $response = $this->from(route('admin.events.edit', $event->id))
            ->put(route('admin.events.update', $event->id), $payload);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['event_name']);
    }

    // Exception path for update() requires refactor to inject dependency for mocking.

    public function test_destroy_success()
    {
        $event = Event::factory()->create();
        $response = $this->delete(route('admin.events.destroy', $event->id));
        $response->assertRedirect(route('admin.events.index'));
        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }

    public function test_destroy_404_when_missing()
    {
        $response = $this->delete(route('admin.events.destroy', 99999));
        $response->assertNotFound();
    }

    public function test_bulk_destroy_success()
    {
        $events = Event::factory()->count(3)->create();
        $ids = $events->pluck('id')->all();
        $response = $this->delete(route('admin.events.bulkDestroy'), ['ids' => $ids]);
        $response->assertOk();
        $response->assertJson(['success' => 'Event deleted succesfully']);
        foreach ($ids as $id) {
            $this->assertDatabaseMissing('events', ['id' => $id]);
        }
    }

    public function test_bulk_destroy_validation_error_when_ids_missing()
    {
        $response = $this->delete(route('admin.events.bulkDestroy'), []);
        $response->assertSessionHasErrors(['ids']);
    }

    // Exception path for bulkDestroy() requires refactor to inject dependency for mocking.
}


