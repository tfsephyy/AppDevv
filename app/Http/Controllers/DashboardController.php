<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAccount;
use App\Models\Schedule;
use App\Models\CounselingSession;
use App\Models\Post;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // Return schedule history for a student as JSON
    public function studentScheduleHistory($id)
    {
        $schedules = \App\Models\Schedule::where('user_account_id', $id)
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();
        $history = $schedules->map(function($sch) {
            return [
                'date' => \Carbon\Carbon::parse($sch->date)->format('M d, Y'),
                'time' => \Carbon\Carbon::parse($sch->time)->format('g:i A'),
                'duration' => $sch->duration,
                'status' => $sch->status
            ];
        });
        return response()->json($history);
    }
    public function index()
    {
        // Total students
        $totalStudents = UserAccount::count();
        
        // Today's schedules
        $todaySchedules = Schedule::whereDate('date', Carbon::today())->count();
        
        // Yesterday's schedules for comparison
        $yesterdaySchedules = Schedule::whereDate('date', Carbon::yesterday())->count();
        $schedulesDifference = $todaySchedules - $yesterdaySchedules;
        
        // New students this week
        $weekStart = Carbon::now()->startOfWeek();
        $newStudentsThisWeek = UserAccount::where('created_at', '>=', $weekStart)->count();
        
        // New students last week for comparison
        $lastWeekStart = Carbon::now()->subWeek()->startOfWeek();
        $lastWeekEnd = Carbon::now()->subWeek()->endOfWeek();
        $newStudentsLastWeek = UserAccount::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->count();
        $studentsDifference = $newStudentsThisWeek - $newStudentsLastWeek;
        
        // All user accounts ordered by date joined (most recent first)
        $recentStudents = UserAccount::orderBy('created_at', 'desc')->get();
        
        // Active counseling sessions
        $activeSessions = CounselingSession::where('archived', false)
            ->where('status', 'Active')
            ->count();
        
        // Total posts
        $totalPosts = Post::where('archived', false)->count();
        
        // Recent schedules (upcoming, not completed)
        $recentSchedules = Schedule::where('date', '>=', Carbon::today())
            ->where('status', '!=', 'Completed')
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->take(5)
            ->with('userAccount')
            ->get();
        
        return view('dashboard', compact(
            'totalStudents',
            'todaySchedules',
            'schedulesDifference',
            'newStudentsThisWeek',
            'studentsDifference',
            'recentStudents',
            'activeSessions',
            'totalPosts',
            'recentSchedules'
        ));
    }
}
