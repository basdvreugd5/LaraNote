<?php

namespace Tests\Feature;

use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoteFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_note(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('notes.store'), [
                'title' => 'My first note',
                'body' => 'Some content',
            ]);

        $response->assertRedirect(route('notes.index'));

        $this->assertDatabaseHas('notes', [
            'user_id' => $user->id,
            'title' => 'My first note',
            'archived' => false,
        ]);
    }

    public function test_user_cannot_create_note_without_title(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('notes.store'), [
                'body' => 'Missing title',
            ]);

        $response->assertSessionHasErrors('title');

        $this->assertDatabaseCount('notes', 0);
    }

    public function test_user_cannot_exceed_note_limit(): void
    {
        $user = User::factory()->create();

        Note::factory()
            ->count(Note::MAX_PER_USER)
            ->for($user)
            ->create();

        $response = $this
            ->actingAs($user)
            ->post(route('notes.store'), [
                'title' => 'Too many',
            ]);

        $response->assertForbidden();

        $this->assertDatabaseCount('notes', Note::MAX_PER_USER);
    }

    public function test_user_cannot_update_another_users_note(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();

        $note = Note::factory()
            ->for($owner)
            ->create();

        $response = $this
            ->actingAs($other)
            ->patch(route('notes.update', $note), [
                'title' => 'Hacked',
            ]);

        $response->assertForbidden();

        $this->assertDatabaseMissing('notes', [
            'id' => $note->id,
            'title' => 'Hacked',
        ]);
    }
}
