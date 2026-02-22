<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schedules = [
            [
                'user_account_id' => 1,
                'date' => Carbon::today()->toDateString(),
                'time' => '09:00:00',
                'duration' => '1 hour',
                'status' => 'Upcoming',
            ],
            [
                'user_account_id' => 2,
                'date' => Carbon::today()->toDateString(),
                'time' => '10:30:00',
                'duration' => '1 hour',
                'status' => 'Upcoming',
            ],
            [
                'user_account_id' => 3,
                'date' => Carbon::today()->toDateString(),
                'time' => '13:00:00',
                'duration' => '30 minutes',
                'status' => 'Upcoming',
            ],
            [
                'user_account_id' => 4,
                'date' => Carbon::tomorrow()->toDateString(),
                'time' => '09:00:00',
                'duration' => '1 hour',
                'status' => 'Upcoming',
            ],
            [
                'user_account_id' => 5,
                'date' => Carbon::tomorrow()->toDateString(),
                'time' => '11:00:00',
                'duration' => '45 minutes',
                'status' => 'Upcoming',
            ],
            [
                'user_account_id' => 6,
                'date' => Carbon::today()->addDays(2)->toDateString(),
                'time' => '10:00:00',
                'duration' => '1 hour',
                'status' => 'Upcoming',
            ],
            [
                'user_account_id' => 7,
                'date' => Carbon::today()->addDays(3)->toDateString(),
                'time' => '14:00:00',
                'duration' => '1 hour',
                'status' => 'Upcoming',
            ],
            [
                'user_account_id' => 8,
                'date' => Carbon::yesterday()->toDateString(),
                'time' => '09:00:00',
                'duration' => '1 hour',
                'status' => 'Completed',
            ],
            [
                'user_account_id' => 9,
                'date' => Carbon::yesterday()->toDateString(),
                'time' => '15:00:00',
                'duration' => '30 minutes',
                'status' => 'Completed',
            ],
            [
                'user_account_id' => 10,
                'date' => Carbon::today()->addDays(4)->toDateString(),
                'time' => '11:30:00',
                'duration' => '1 hour',
                'status' => 'Upcoming',
            ],
            [
                'user_account_id' => 11,
                'date' => Carbon::today()->addDays(5)->toDateString(),
                'time' => '09:30:00',
                'duration' => '45 minutes',
                'status' => 'Upcoming',
            ],
            [
                'user_account_id' => 12,
                'date' => Carbon::today()->addDays(6)->toDateString(),
                'time' => '13:30:00',
                'duration' => '1 hour',
                'status' => 'Upcoming',
            ],
            [
                'user_account_id' => 13,
                'date' => Carbon::today()->addDays(7)->toDateString(),
                'time' => '10:15:00',
                'duration' => '30 minutes',
                'status' => 'Upcoming',
            ],
            [
                'user_account_id' => 14,
                'date' => Carbon::today()->addDays(8)->toDateString(),
                'time' => '14:45:00',
                'duration' => '1 hour',
                'status' => 'Upcoming',
            ],
            [
                'user_account_id' => 15,
                'date' => Carbon::today()->addDays(9)->toDateString(),
                'time' => '11:00:00',
                'duration' => '45 minutes',
                'status' => 'Upcoming',
            ],
            [
                'user_account_id' => 15,
                'date' => Carbon::today()->addDays(10)->toDateString(),
                'time' => '15:30:00',
                'duration' => '1 hour',
                'status' => 'Upcoming',
            ],
        ];

        foreach ($schedules as $schedule) {
            Schedule::create($schedule);
        }
    }
}
