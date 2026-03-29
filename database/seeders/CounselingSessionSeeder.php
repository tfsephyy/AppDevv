<?php

namespace Database\Seeders;

use App\Models\CounselingSession;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CounselingSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sessions = [
            [
                'user_account_id' => 1,
                'status' => 'Active',
                'concern' => 'Anxiety and stress management',
                'last_session' => Carbon::today()->subDays(3)->toDateString(),
                'note' => 'Student shows progress in coping mechanisms. Continue weekly sessions.',
            ],
            [
                'user_account_id' => 2,
                'status' => 'Active',
                'concern' => 'Academic pressure',
                'last_session' => Carbon::today()->subDays(1)->toDateString(),
                'note' => 'Developing time management strategies. Positive outlook.',
            ],
            [
                'user_account_id' => 3,
                'status' => 'Completed',
                'concern' => 'Adjustment issues',
                'last_session' => Carbon::today()->subDays(30)->toDateString(),
                'note' => 'Successfully adapted to university life. Case closed.',
            ],
            [
                'user_account_id' => 4,
                'status' => 'Active',
                'concern' => 'Social anxiety',
                'last_session' => Carbon::today()->subDays(5)->toDateString(),
                'note' => 'Working on building social connections. Gradual improvement noted.',
            ],
            [
                'user_account_id' => 5,
                'status' => 'Active',
                'concern' => 'Depression symptoms',
                'last_session' => Carbon::today()->subDays(2)->toDateString(),
                'note' => 'Referred to psychiatrist for medication evaluation. Close monitoring required.',
            ],
            [
                'user_account_id' => 6,
                'status' => 'Inactive',
                'concern' => 'Family issues',
                'last_session' => Carbon::today()->subDays(45)->toDateString(),
                'note' => 'Student requested pause in sessions. Open to return when ready.',
            ],
            [
                'user_account_id' => 7,
                'status' => 'Active',
                'concern' => 'Career counseling',
                'last_session' => Carbon::today()->subDays(7)->toDateString(),
                'note' => 'Exploring different career paths. Scheduled aptitude testing.',
            ],
            [
                'user_account_id' => 8,
                'status' => 'Completed',
                'concern' => 'Relationship problems',
                'last_session' => Carbon::today()->subDays(60)->toDateString(),
                'note' => 'Student resolved issues. No further sessions needed.',
            ],
            [
                'user_account_id' => 9,
                'status' => 'Active',
                'concern' => 'Low self-esteem',
                'last_session' => Carbon::today()->subDays(4)->toDateString(),
                'note' => 'Building confidence through cognitive behavioral techniques.',
            ],
            [
                'user_account_id' => 10,
                'status' => 'Active',
                'concern' => 'Academic burnout',
                'last_session' => Carbon::today()->subDays(1)->toDateString(),
                'note' => 'Implementing self-care routines. Showing signs of recovery.',
            ],
            [
                'user_account_id' => 11,
                'status' => 'Active',
                'concern' => 'Test anxiety',
                'last_session' => Carbon::today()->subDays(3)->toDateString(),
                'note' => 'Learning relaxation techniques and study strategies.',
            ],
            [
                'user_account_id' => 12,
                'status' => 'Completed',
                'concern' => 'Peer pressure issues',
                'last_session' => Carbon::today()->subDays(25)->toDateString(),
                'note' => 'Successfully developed assertiveness skills. Case resolved.',
            ],
            [
                'user_account_id' => 13,
                'status' => 'Active',
                'concern' => 'Eating disorder concerns',
                'last_session' => Carbon::today()->subDays(2)->toDateString(),
                'note' => 'Working with nutritionist. Monitoring progress closely.',
            ],
            [
                'user_account_id' => 14,
                'status' => 'Inactive',
                'concern' => 'Financial stress',
                'last_session' => Carbon::today()->subDays(20)->toDateString(),
                'note' => 'Connected with financial aid office. Sessions on hold.',
            ],
            [
                'user_account_id' => 15,
                'status' => 'Active',
                'concern' => 'Sleep difficulties',
                'last_session' => Carbon::today()->subDays(4)->toDateString(),
                'note' => 'Establishing better sleep hygiene. Some improvement noted.',
            ],
            [
                'user_account_id' => 15,
                'status' => 'Active',
                'concern' => 'Identity exploration',
                'last_session' => Carbon::today()->subDays(6)->toDateString(),
                'note' => 'Supporting self-discovery process. Creating safe space for exploration.',
            ],
        ];

        foreach ($sessions as $session) {
            CounselingSession::create($session);
        }
    }
}
