<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\UserAccount;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index()
    {
        // Auto-complete past schedules (only dates before today)
        $today = Carbon::today();
        Schedule::where('status', 'Upcoming')
            ->where('date', '<', $today)
            ->update(['status' => 'Completed']);

        $schedules = Schedule::with('userAccount')
            ->whereHas('userAccount')
            ->whereIn('status', ['Upcoming', 'Pending'])
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->get();
        
        return view('scheduling', compact('schedules'));
    }

    public function getBookedSlots(Request $request)
    {
        $date = $request->input('date');
        
        $schedules = Schedule::where('date', $date)
            ->whereIn('status', ['Upcoming', 'Pending'])
            ->get(['time', 'duration']);
        
        $bookedSlots = [];
        foreach ($schedules as $schedule) {
            $startTime = Carbon::parse($schedule->time);
            $duration = (int) $schedule->duration;
            
            // Add all 30-minute slots that are blocked by this appointment
            $endTime = $startTime->copy()->addMinutes($duration);
            $currentSlot = $startTime->copy();
            
            while ($currentSlot < $endTime) {
                $bookedSlots[] = $currentSlot->format('H:i');
                $currentSlot->addMinutes(30);
            }
        }
        
        return response()->json($bookedSlots);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'schoolId' => 'required|exists:user_accounts,schoolId',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
            'duration' => 'required|in:60,90',
        ]);

        $userAccount = UserAccount::where('schoolId', $validated['schoolId'])->first();

        // Check for overlapping schedules
        $startTime = Carbon::parse($validated['time']);
        $duration = (int) $validated['duration'];
        $endTime = $startTime->copy()->addMinutes($duration);

        $overlapping = Schedule::where('date', $validated['date'])
            ->whereIn('status', ['Upcoming', 'Pending'])
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where(function ($q) use ($startTime, $endTime) {
                    $q->where('time', '<', $endTime->format('H:i'))
                      ->whereRaw("ADDTIME(time, SEC_TO_TIME(duration * 60)) > ?", [$startTime->format('H:i')]);
                });
            })
            ->exists();

        if ($overlapping) {
            return redirect()->back()->withErrors(['time' => 'This time slot is already booked.'])->withInput();
        }

        Schedule::create([
            'user_account_id' => $userAccount->id,
            'date' => $validated['date'],
            'time' => $validated['time'],
            'duration' => $validated['duration'],
            'status' => 'Upcoming',
        ]);

        return redirect()->route('scheduling')->with('success', 'Schedule created successfully!');
    }

    public function show($id)
    {
        $schedule = Schedule::with('userAccount')->findOrFail($id);
        
        // Get all schedules for this user
        $scheduleHistory = Schedule::where('user_account_id', $schedule->user_account_id)
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();
        
        return response()->json([
            'schedule' => $schedule,
            'user' => $schedule->userAccount,
            'history' => $scheduleHistory
        ]);
    }

    public function complete($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->update(['status' => 'Completed']);
        
        return redirect()->route('scheduling')->with('success', 'Schedule marked as completed!');
    }

    public function archive()
    {
        $schedules = Schedule::with('userAccount')
            ->whereHas('userAccount')
            ->where('status', 'Completed')
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get()
            ->map(function($schedule) {
                return [
                    'id' => $schedule->id,
                    'user_account' => [
                        'name' => $schedule->userAccount->name,
                    ],
                    'date' => Carbon::parse($schedule->date)->format('F d, Y'),
                    'time' => Carbon::parse($schedule->time)->format('g:i A'),
                    'duration' => $schedule->duration,
                    'status' => $schedule->status
                ];
            });
        
        return response()->json($schedules);
    }
    
    public function getUserAccounts()
    {
        $users = UserAccount::select('id', 'schoolId', 'name', 'program')
            ->orderBy('schoolId', 'asc')
            ->get();
        
        return response()->json($users);
    }
    
    public function unarchive($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->update(['status' => 'Upcoming']);
        
        return response()->json(['success' => true]);
    }
    
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();
        
        return response()->json(['success' => true]);
    }
}
