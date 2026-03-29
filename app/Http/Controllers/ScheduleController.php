<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\UserAccount;
use App\Models\Notification;
use App\Models\AdminNotification;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index()
    {
        // Auto-complete past schedules (date AND time past current moment)
        $now = Carbon::now();
        Schedule::where('status', 'Upcoming')
            ->whereRaw("CONCAT(date, ' ', time) < ?", [$now->format('Y-m-d H:i:s')])
            ->update(['status' => 'Completed']);

        $schedules = Schedule::with('userAccount')
            ->whereHas('userAccount')
            ->whereIn('status', ['Upcoming', 'Pending', 'Denied', 'Reschedule in Process', 'Student Reschedule Request'])
            ->orderBy('id', 'desc')
            ->get();
        
        return view('scheduling', compact('schedules'));
    }

    public function getBookedSlots(Request $request)
    {
        $date = $request->input('date');
        
        $schedules = Schedule::where('date', $date)
            ->whereIn('status', ['Upcoming', 'Pending', 'Reschedule in Process'])
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
            ->whereIn('status', ['Upcoming', 'Pending', 'Reschedule in Process'])
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

        $schedule = Schedule::create([
            'user_account_id' => $userAccount->id,
            'date' => $validated['date'],
            'time' => $validated['time'],
            'duration' => $validated['duration'],
            'status' => 'Upcoming',
        ]);

        // Notify the student that admin has booked an appointment for them
        Notification::create([
            'user_id' => $userAccount->id,
            'title' => 'Appointment Scheduled by Admin',
            'message' => 'An appointment has been scheduled for you on ' . Carbon::parse($validated['date'])->format('M d, Y') . ' at ' . Carbon::parse($validated['time'])->format('g:i A') . '.',
            'type' => 'schedule',
            'related_id' => $schedule->id,
            'read' => false,
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

    public function accept($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->update(['status' => 'Upcoming']);

        Notification::create([
            'user_id' => $schedule->user_account_id,
            'title' => 'Schedule Accepted',
            'message' => 'Your schedule on ' . Carbon::parse($schedule->date)->format('M d, Y') . ' at ' . Carbon::parse($schedule->time)->format('g:i A') . ' has been accepted.',
            'type' => 'schedule',
            'related_id' => $schedule->id,
            'read' => false,
        ]);

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['success' => true, 'id' => (int)$id, 'status' => 'Upcoming']);
        }

        return redirect()->route('scheduling')->with('success', 'Schedule accepted and student notified!');
    }

    public function deny($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->update(['status' => 'Denied']);

        Notification::create([
            'user_id' => $schedule->user_account_id,
            'title' => 'Schedule Denied',
            'message' => 'Your schedule on ' . Carbon::parse($schedule->date)->format('M d, Y') . ' at ' . Carbon::parse($schedule->time)->format('g:i A') . ' has been denied. Please book a new slot.',
            'type' => 'schedule',
            'related_id' => $schedule->id,
            'read' => false,
        ]);

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['success' => true, 'id' => (int)$id, 'status' => 'Denied']);
        }

        return redirect()->route('scheduling')->with('success', 'Schedule denied and student notified!');
    }

    public function reschedule(Request $request, $id)
    {
        $validated = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
        ]);

        $schedule = Schedule::findOrFail($id);

        $schedule->update([
            'proposed_date' => $validated['date'],
            'proposed_time' => $validated['time'],
            'status' => 'Reschedule in Process',
        ]);

        $newDate = Carbon::parse($validated['date'])->format('M d, Y');
        $newTime = Carbon::parse($validated['time'])->format('g:i A');

        Notification::create([
            'user_id' => $schedule->user_account_id,
            'title' => 'Reschedule Proposed',
            'message' => 'The admin has proposed rescheduling your appointment to ' . $newDate . ' at ' . $newTime . '. Please accept or cancel in your scheduling page.',
            'type' => 'schedule',
            'related_id' => $schedule->id,
            'read' => false,
        ]);

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'id' => (int)$id,
                'status' => 'Reschedule in Process',
                'proposed_date' => $newDate,
                'proposed_time' => $newTime,
            ]);
        }

        return redirect()->route('scheduling')->with('success', 'Reschedule proposed and student notified!');
    }

    public function archive()
    {
        $schedules = Schedule::with('userAccount')
            ->whereHas('userAccount')
            ->whereIn('status', ['Completed', 'Denied', 'Cancelled'])
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
                    'rawDate' => $schedule->date,
                    'time' => Carbon::parse($schedule->time)->format('g:i A'),
                    'rawTime' => $schedule->time,
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

    // -------------------------------------------------------------------------
    // Admin Notification / Pending count endpoints
    // -------------------------------------------------------------------------

    public function pendingCount()
    {
        $count = Schedule::where('status', 'Pending')->count();
        return response()->json(['count' => $count]);
    }

    public function adminNotifications()
    {
        $notifications = AdminNotification::where('read', false)
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($notifications);
    }

    public function adminNotificationRead($id)
    {
        $notification = AdminNotification::findOrFail($id);
        $notification->update(['read' => true]);
        return response()->json(['success' => true]);
    }

    public function adminUnreadCount()
    {
        $count = AdminNotification::where('read', false)->count();
        return response()->json(['count' => $count]);
    }

    public function markAllAdminNotificationsRead()
    {
        AdminNotification::where('read', false)->update(['read' => true]);
        return response()->json(['success' => true]);
    }

    public function acceptStudentReschedule($id)
    {
        $schedule = Schedule::findOrFail($id);

        $newDate = $schedule->proposed_date;
        $newTime = $schedule->proposed_time;

        $schedule->update([
            'date' => $newDate,
            'time' => $newTime,
            'proposed_date' => null,
            'proposed_time' => null,
            'status' => 'Upcoming',
        ]);

        Notification::create([
            'user_id' => $schedule->user_account_id,
            'title' => 'Reschedule Request Approved',
            'message' => 'Your reschedule request has been approved. New appointment: ' . Carbon::parse($newDate)->format('M d, Y') . ' at ' . Carbon::parse($newTime)->format('g:i A') . '.',
            'type' => 'schedule',
            'related_id' => $schedule->id,
            'read' => false,
        ]);

        return response()->json(['success' => true, 'id' => (int)$id, 'status' => 'Upcoming']);
    }

    public function denyStudentReschedule($id)
    {
        $schedule = Schedule::findOrFail($id);

        $schedule->update([
            'proposed_date' => null,
            'proposed_time' => null,
            'status' => 'Upcoming',
        ]);

        Notification::create([
            'user_id' => $schedule->user_account_id,
            'title' => 'Reschedule Request Denied',
            'message' => 'Your reschedule request was denied. Your original appointment on ' . Carbon::parse($schedule->date)->format('M d, Y') . ' at ' . Carbon::parse($schedule->time)->format('g:i A') . ' remains.',
            'type' => 'schedule',
            'related_id' => $schedule->id,
            'read' => false,
        ]);

        return response()->json(['success' => true, 'id' => (int)$id, 'status' => 'Upcoming']);
    }
}
