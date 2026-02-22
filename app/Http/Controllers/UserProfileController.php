<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAccount;

class UserProfileController extends Controller
{
    public function show()
    {
        // Get user database ID from session
        $userId = session('user_id');
        $schoolId = session('school_id');
        
        \Log::info('Profile show - Session data:', [
            'user_id' => $userId,
            'school_id' => $schoolId,
            'user_name' => session('user_name')
        ]);
        
        if (!$userId) {
            \Log::error('Profile show - No user ID in session');
            return response()->json(['error' => 'User not logged in'], 401);
        }
        
        // Find user by database ID (not schoolId)
        $user = UserAccount::find($userId);
        
        if (!$user) {
            \Log::error('Profile show - User not found in database', ['userId' => $userId]);
            return response()->json(['error' => 'User not found in database'], 404);
        }
        
        \Log::info('Profile show - User found', ['user' => $user->toArray()]);
        return response()->json($user);
    }
    
    public function update(Request $request)
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return response()->json(['error' => 'User not logged in'], 401);
        }
        
        // Find user by database ID
        $user = UserAccount::find($userId);
        
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user_accounts,email,' . $user->id,
            'program' => 'required|string|max:255',
            'year' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'picture' => 'nullable|image|max:5120',
        ]);
        
        // Handle picture upload
        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('profile-pictures', 'public');
            $validated['picture'] = $path;
        }
        
        $user->update($validated);
        
        // Update session name if changed
        if (isset($validated['name'])) {
            session(['user_name' => $validated['name']]);
        }
        
        // Update session picture if changed
        if (isset($validated['picture'])) {
            session(['user_picture' => $validated['picture']]);
        }
        
        return response()->json(['success' => true, 'message' => 'Profile updated successfully!', 'user' => $user]);
    }
}
