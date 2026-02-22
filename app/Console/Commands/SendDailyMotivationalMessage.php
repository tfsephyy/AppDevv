<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\MotivationalMessage;
use App\Models\UserAccount;
use App\Models\Notification;

class SendDailyMotivationalMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'motivational:send-daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a random motivational message to all users as daily notification';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get all active (non-archived) motivational messages
        $messages = MotivationalMessage::where('archived', false)->get();

        if ($messages->isEmpty()) {
            $this->error('No active motivational messages found!');
            return Command::FAILURE;
        }

        // Randomly select one message
        $selectedMessage = $messages->random();

        // Get all user accounts
        $users = UserAccount::all();

        if ($users->isEmpty()) {
            $this->error('No users found!');
            return Command::FAILURE;
        }

        $notificationCount = 0;

        // Send notification to each user
        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'title' => 'Daily Motivation',
                'message' => $selectedMessage->message,
                'type' => 'motivational',
                'read' => false,
                'related_id' => $selectedMessage->id,
            ]);

            $notificationCount++;
        }

        $this->info("Successfully sent daily motivational message to {$notificationCount} users.");
        $this->info("Message: " . Str::limit($selectedMessage->message, 50));

        return Command::SUCCESS;
    }
}
