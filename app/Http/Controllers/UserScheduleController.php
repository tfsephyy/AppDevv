<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use Carbon\Carbon;

class UserScheduleController extends Controller
{
    public function index()
    {
        $userAccountId = session('user_id');
        
        if (!$userAccountId) {
            return redirect()->route('login')->with('error', 'Please login to continue');
        }
        
        $schedules = Schedule::where('user_account_id', $userAccountId)
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();
        
        return view('user.user-scheduling', compact('schedules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'duration' => 'required|integer|in:60,90',
        ]);

        Schedule::create([
            'user_account_id' => session('user_id'),
            'date' => $request->date,
            'time' => $request->time,
            'duration' => $request->duration,
            'status' => 'Upcoming'
        ]);

        return redirect()->route('user.schedules')->with('success', 'Appointment booked successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'duration' => 'required|integer|in:60,90'
        ]);

        $schedule = Schedule::findOrFail($id);
        $userAccountId = session('user_id');

        // Ensure user can only update their own schedule
        if ($schedule->user_account_id !== $userAccountId) {
            return redirect()->route('user.schedules')->with('error', 'Unauthorized action');
        }

        $schedule->update([
            'date' => $request->date,
            'time' => $request->time,
            'duration' => $request->duration
        ]);

        return redirect()->route('user.schedules')->with('success', 'Appointment updated successfully!');
    }

    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $userAccountId = session('user_id');

        // Ensure user can only delete their own schedule
        if ($schedule->user_account_id !== $userAccountId) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $schedule->delete();

        return response()->json(['success' => true]);
    }

    public function getBookedSlots(Request $request)
    {
        $date = $request->input('date');
        
        \Log::info('Fetching booked slots for date: ' . $date);
        
        // Get all schedules for the given date (excluding cancelled/completed)
        $schedules = Schedule::where('date', $date)
            ->whereIn('status', ['Upcoming', 'Pending'])
            ->get(['time', 'duration']);
        
        \Log::info('Found schedules: ' . $schedules->count());
        
        $bookedSlots = [];
        
        foreach ($schedules as $schedule) {
            $startTime = Carbon::parse($schedule->time);
            $duration = (int) $schedule->duration;
            
            \Log::info("Processing schedule: time={$schedule->time}, duration={$duration}");
            
            // Calculate all 30-minute intervals blocked by this appointment
            $endTime = $startTime->copy()->addMinutes($duration);
            $currentSlot = $startTime->copy();
            
            while ($currentSlot < $endTime) {
                $bookedSlots[] = $currentSlot->format('H:i');
                $currentSlot->addMinutes(30);
            }
        }
        
        $uniqueSlots = array_unique($bookedSlots);
        \Log::info('Returning booked slots: ' . json_encode(array_values($uniqueSlots)));
        
        return response()->json(array_values($uniqueSlots));
    }
}
