<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CounselingSession;
use App\Models\UserAccount;
use App\Models\Schedule;
use App\Models\Notification;

class CounselingController extends Controller
{
    public function index()
    {
        // Get only the most recent session for each student
        $sessions = CounselingSession::with('userAccount')
            ->where('archived', false)
            ->whereIn('id', function($query) {
                $query->selectRaw('MAX(id)')
                    ->from('counseling_sessions')
                    ->where('archived', false)
                    ->groupBy('user_account_id');
            })
            ->orderBy('last_session', 'desc')
            ->get();
        
        return view('counceling', compact('sessions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'schoolId' => 'required|exists:user_accounts,schoolId',
            'status' => 'required|in:Active,Inactive,Completed',
            'concern' => 'required|string|max:255',
            'last_session' => 'required|date',
            'note' => 'nullable|string',
        ]);

        $userAccount = UserAccount::where('schoolId', $validated['schoolId'])->first();

        $session = CounselingSession::create([
            'user_account_id' => $userAccount->id,
            'status' => $validated['status'],
            'concern' => $validated['concern'],
            'last_session' => $validated['last_session'],
            'note' => $validated['note'],
        ]);
        
        // Create notification for the user
        Notification::create([
            'user_id' => $userAccount->id,
            'title' => 'New Counseling Session',
            'message' => 'A counseling session has been made. Check it out now',
            'type' => 'session',
            'related_id' => $session->id,
            'read' => false,
        ]);

        return redirect()->route('counceling')->with('success', 'Counseling session created successfully!');
    }

    public function show($id)
    {
        $session = CounselingSession::with('userAccount')->findOrFail($id);
        
        return response()->json($session);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:Active,Inactive,Completed',
            'concern' => 'required|string|max:255',
            'last_session' => 'required|date',
            'note' => 'nullable|string',
        ]);

        $session = CounselingSession::findOrFail($id);
        $session->update($validated);

        return redirect()->route('counceling')->with('success', 'Counseling session updated successfully!');
    }

    public function archive($id)
    {
        $session = CounselingSession::findOrFail($id);
        $session->update(['archived' => true]);
        
        return response()->json(['success' => true]);
    }

    public function getArchived()
    {
        $sessions = CounselingSession::with('userAccount')
            ->where('archived', true)
            ->orderBy('last_session', 'desc')
            ->get();
        
        return response()->json($sessions);
    }

    public function unarchive($id)
    {
        $session = CounselingSession::findOrFail($id);
        $session->update(['archived' => false]);
        
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $session = CounselingSession::findOrFail($id);
        $session->delete();
        
        return response()->json(['success' => true]);
    }

    public function getUserSchedules($schoolId)
    {
        $userAccount = UserAccount::where('schoolId', $schoolId)->first();
        
        if (!$userAccount) {
            return response()->json([]);
        }
        
        $schedules = Schedule::where('user_account_id', $userAccount->id)
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->limit(5)
            ->get(['date', 'time']);
        
        return response()->json($schedules);
    }

    public function getStudentHistory($userId)
    {
        $sessions = CounselingSession::with('userAccount')
            ->where('user_account_id', $userId)
            ->orderBy('last_session', 'desc')
            ->get();
        
        return response()->json($sessions);
    }
}
