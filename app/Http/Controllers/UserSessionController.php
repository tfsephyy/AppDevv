<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CounselingSession;

class UserSessionController extends Controller
{
    public function index()
    {
        $userAccountId = session('user_id');
        
        if (!$userAccountId) {
            return redirect()->route('login')->with('error', 'Please login to continue');
        }
        
        $sessions = CounselingSession::where('user_account_id', $userAccountId)
            ->where('archived', false)
            ->orderBy('last_session', 'desc')
            ->get();
        
        return view('user.user-sessions', compact('sessions'));
    }
}
