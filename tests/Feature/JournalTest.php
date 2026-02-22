<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Journal;

class JournalTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_journals_endpoint_returns_data()
    {
        // Create some test public journals
        Journal::create([
            'user_id' => 'test_user_1',
            'title' => 'Test Public Journal 1',
            'content' => 'This is a test public journal entry.',
            'is_public' => true,
            'archived' => false,
            'images' => [],
        ]);

        Journal::create([
            'user_id' => 'test_user_2',
            'title' => 'Test Public Journal 2',
            'content' => 'This is another test public journal entry.',
            'is_public' => true,
            'archived' => false,
            'images' => [],
        ]);

        // Test the endpoint
        $response = $this->get('/user/journal-public');

        $response->assertStatus(200);

        $data = $response->json();

        // Should return an array with at least 2 journals
        $this->assertIsArray($data);
        $this->assertGreaterThanOrEqual(2, count($data));

        // Check that each journal has the required fields
        foreach ($data as $journal) {
            $this->assertArrayHasKey('id', $journal);
            $this->assertArrayHasKey('title', $journal);
            $this->assertArrayHasKey('content', $journal);
            $this->assertArrayHasKey('user_name', $journal);
            $this->assertArrayHasKey('created_at', $journal);
            $this->assertArrayHasKey('likes_count', $journal);
            $this->assertArrayHasKey('comments_count', $journal);
        }
    }

    public function test_toggle_public_status()
    {
        // Create a test journal
        $journal = Journal::create([
            'user_id' => 'test_user_1',
            'title' => 'Test Journal',
            'content' => 'This is a test journal entry.',
            'is_public' => false, // Start as private
            'archived' => false,
            'images' => [],
        ]);

        // Test toggling to public
        $response = $this->post("/user/journal/{$journal->id}/toggle-public");

        $response->assertStatus(200);

        $data = $response->json();

        $this->assertTrue($data['success']);
        $this->assertTrue($data['is_public']);
        $this->assertEquals('Journal is now public', $data['message']);

        // Refresh the journal from database
        $journal->refresh();
        $this->assertTrue($journal->is_public);

        // Test toggling back to private
        $response = $this->post("/user/journal/{$journal->id}/toggle-public");

        $response->assertStatus(200);

        $data = $response->json();

        $this->assertTrue($data['success']);
        $this->assertFalse($data['is_public']);
        $this->assertEquals('Journal is now private', $data['message']);

        // Refresh the journal from database
        $journal->refresh();
        $this->assertFalse($journal->is_public);
    }
}