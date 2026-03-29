<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\AdminNotification;
use App\Models\Notification;
use App\Models\UserAccount;
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

        $schedule = Schedule::create([
            'user_account_id' => session('user_id'),
            'date' => $request->date,
            'time' => $request->time,
            'duration' => $request->duration,
            'status' => 'Pending'
        ]);

        // Notify admin about new pending schedule request
        AdminNotification::create([
            'title' => 'New Appointment Request',
            'message' => 'A student has requested a counseling appointment on ' . \Carbon\Carbon::parse($request->date)->format('M d, Y') . ' at ' . \Carbon\Carbon::parse($request->time)->format('g:i A') . '.',
            'type' => 'schedule',
            'read' => false,
            'related_id' => $schedule->id,
        ]);

        // Notify student their request was submitted
        Notification::create([
            'user_id' => session('user_id'),
            'title' => 'Appointment Request Submitted',
            'message' => 'Your appointment request for ' . \Carbon\Carbon::parse($request->date)->format('M d, Y') . ' at ' . \Carbon\Carbon::parse($request->time)->format('g:i A') . ' has been submitted and is awaiting admin approval.',
            'type' => 'schedule',
            'related_id' => $schedule->id,
            'read' => false,
        ]);

        return redirect()->route('user.schedules')->with('success', 'Appointment request submitted! Awaiting admin approval.');
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

        // Notify admin of the change
        AdminNotification::create([
            'title' => 'Appointment Edited by Student',
            'message' => 'A student has edited their appointment to ' . \Carbon\Carbon::parse($request->date)->format('M d, Y') . ' at ' . \Carbon\Carbon::parse($request->time)->format('g:i A') . ' (' . ($request->duration == 60 ? '1 hour' : '1.5 hours') . ').',
            'type' => 'schedule',
            'read' => false,
            'related_id' => $schedule->id,
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
            ->whereIn('status', ['Upcoming', 'Pending', 'Reschedule in Process'])
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

    public function acceptReschedule($id)
    {
        $schedule = Schedule::findOrFail($id);
        $userAccountId = session('user_id');

        if ($schedule->user_account_id !== $userAccountId) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($schedule->status !== 'Reschedule in Process') {
            return response()->json(['error' => 'Not in reschedule state'], 400);
        }

        $schedule->update([
            'date' => $schedule->proposed_date,
            'time' => $schedule->proposed_time,
            'proposed_date' => null,
            'proposed_time' => null,
            'status' => 'Upcoming',
        ]);

        // Notify admin
        AdminNotification::create([
            'title' => 'Reschedule Accepted',
            'message' => 'A student has accepted the rescheduled appointment to ' . Carbon::parse($schedule->date)->format('M d, Y') . ' at ' . Carbon::parse($schedule->time)->format('g:i A') . '.',
            'type' => 'schedule',
            'read' => false,
            'related_id' => $schedule->id,
        ]);

        return response()->json(['success' => true]);
    }

    public function cancelReschedule($id)
    {
        $schedule = Schedule::findOrFail($id);
        $userAccountId = session('user_id');

        if ($schedule->user_account_id !== $userAccountId) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($schedule->status !== 'Reschedule in Process') {
            return response()->json(['error' => 'Not in reschedule state'], 400);
        }

        $schedule->update([
            'proposed_date' => null,
            'proposed_time' => null,
            'status' => 'Upcoming',
        ]);

        // Notify admin
        AdminNotification::create([
            'title' => 'Reschedule Declined by Student',
            'message' => 'A student has declined the proposed reschedule. Original appointment on ' . Carbon::parse($schedule->date)->format('M d, Y') . ' at ' . Carbon::parse($schedule->time)->format('g:i A') . ' remains.',
            'type' => 'schedule',
            'read' => false,
            'related_id' => $schedule->id,
        ]);

        return response()->json(['success' => true]);
    }

    public function cancel($id)
    {
        $schedule = Schedule::findOrFail($id);
        $userAccountId = session('user_id');

        if ($schedule->user_account_id !== $userAccountId) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $schedule->update(['status' => 'Cancelled']);

        AdminNotification::create([
            'title' => 'Appointment Cancelled by Student',
            'message' => 'A student has cancelled their appointment on ' . Carbon::parse($schedule->date)->format('M d, Y') . ' at ' . Carbon::parse($schedule->time)->format('g:i A') . '.',
            'type' => 'schedule',
            'read' => false,
            'related_id' => $schedule->id,
        ]);

        // Notify student of cancellation confirmation
        Notification::create([
            'user_id' => $userAccountId,
            'title' => 'Appointment Cancelled',
            'message' => 'Your appointment on ' . Carbon::parse($schedule->date)->format('M d, Y') . ' at ' . Carbon::parse($schedule->time)->format('g:i A') . ' has been cancelled.',
            'type' => 'schedule',
            'related_id' => $schedule->id,
            'read' => false,
        ]);

        return response()->json(['success' => true]);
    }

    public function requestReschedule(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
        ]);

        $schedule = Schedule::findOrFail($id);
        $userAccountId = session('user_id');

        if ($schedule->user_account_id !== $userAccountId) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $schedule->update([
            'proposed_date' => $request->date,
            'proposed_time' => $request->time,
            'status' => 'Student Reschedule Request',
        ]);

        $newDate = Carbon::parse($request->date)->format('M d, Y');
        $newTime = Carbon::parse($request->time)->format('g:i A');

        AdminNotification::create([
            'title' => 'Student Requested Reschedule',
            'message' => 'A student has requested to reschedule their appointment to ' . $newDate . ' at ' . $newTime . '. Please review and approve or deny.',
            'type' => 'schedule',
            'read' => false,
            'related_id' => $schedule->id,
        ]);

        return response()->json(['success' => true]);
    }
}
