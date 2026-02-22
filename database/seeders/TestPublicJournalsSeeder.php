<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Journal;

class TestPublicJournalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some test public journals
        Journal::create([
            'user_id' => 'test_user_1',
            'title' => 'My Journey to Self-Discovery',
            'content' => 'Today I started my journey of self-discovery. It\'s been challenging but rewarding. I\'ve learned that the most important relationship we have is with ourselves.',
            'is_public' => true,
            'archived' => false,
            'images' => [],
        ]);

        Journal::create([
            'user_id' => 'test_user_2',
            'title' => 'Overcoming Fear',
            'content' => 'Fear has always held me back from pursuing my dreams. Today, I took a small step towards facing that fear. It was terrifying but liberating.',
            'is_public' => true,
            'archived' => false,
            'images' => [],
        ]);

        Journal::create([
            'user_id' => 'test_user_3',
            'title' => 'Gratitude Practice',
            'content' => 'Starting a daily gratitude practice has completely changed my perspective. Even on difficult days, I can find things to be thankful for.',
            'is_public' => true,
            'archived' => false,
            'images' => [],
        ]);

        $this->command->info('Created 3 test public journals');
    }
}
