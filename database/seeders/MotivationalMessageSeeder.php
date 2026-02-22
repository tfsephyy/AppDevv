<?php

namespace Database\Seeders;

use App\Models\MotivationalMessage;
use Illuminate\Database\Seeder;

class MotivationalMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $messages = [
            [
                'message' => 'Every expert was once a beginner. Your journey starts with the first step.',
                'archived' => false,
            ],
            [
                'message' => 'Success is not final, failure is not fatal: It is the courage to continue that counts.',
                'archived' => false,
            ],
            [
                'message' => 'The only way to do great work is to love what you do.',
                'archived' => false,
            ],
            [
                'message' => 'Believe you can and you\'re halfway there.',
                'archived' => false,
            ],
            [
                'message' => 'Your time is limited, so don\'t waste it living someone else\'s life.',
                'archived' => false,
            ],
            [
                'message' => 'The future belongs to those who believe in the beauty of their dreams.',
                'archived' => false,
            ],
            [
                'message' => 'You miss 100% of the shots you don\'t take.',
                'archived' => false,
            ],
            [
                'message' => 'The best way to predict the future is to create it.',
                'archived' => false,
            ],
            [
                'message' => 'Don\'t watch the clock; do what it does. Keep going.',
                'archived' => false,
            ],
            [
                'message' => 'The only impossible journey is the one you never begin.',
                'archived' => false,
            ],
            [
                'message' => 'Your limitation—it\'s only your imagination.',
                'archived' => false,
            ],
            [
                'message' => 'Push yourself, because no one else is going to do it for you.',
                'archived' => false,
            ],
            [
                'message' => 'Great things never come from comfort zones.',
                'archived' => false,
            ],
            [
                'message' => 'Dream it. Wish it. Do it.',
                'archived' => false,
            ],
            [
                'message' => 'Success doesn\'t just find you. You have to go out and get it.',
                'archived' => false,
            ],
            [
                'message' => 'The harder you work for something, the greater you\'ll feel when you achieve it.',
                'archived' => false,
            ],
            [
                'message' => 'Dream bigger. Do bigger.',
                'archived' => false,
            ],
            [
                'message' => 'Don\'t stop when you\'re tired. Stop when you\'re done.',
                'archived' => false,
            ],
            [
                'message' => 'Wake up with determination. Go to bed with satisfaction.',
                'archived' => false,
            ],
            [
                'message' => 'Do something today that your future self will thank you for.',
                'archived' => false,
            ],
        ];

        foreach ($messages as $message) {
            MotivationalMessage::create($message);
        }
    }
}