<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        try {
            // Log the logout attempt
            Log::info('Logout attempt', ['session_id' => $request->session()->getId()]);
            
            // Clear all session data
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            // Log successful logout
            Log::info('Logout successful, redirecting to landing page');
            
            // Redirect to the landing page with success message
            return redirect('/')->with('success', 'You have been logged out successfully');
        } catch (\Exception $e) {
            // Log any errors
            Log::error('Logout error: ' . $e->getMessage());
            
            // Still try to redirect even if there's an error
            return redirect('/');
        }
    }
}
