<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\MotivationalMessage;
use App\Models\Notification;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        // Validate inputs
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'schoolId' => 'required|string',
        ]);

        // Check admin table
        $admin = DB::table('admin_table')
            ->where('email', $validated['email'])
            ->where('schoolId', $validated['schoolId'])
            ->first();

        if ($admin && Hash::check($validated['password'], $admin->password)) {
            $request->session()->put('admin_logged_in', true);
            $request->session()->put('user_type', 'admin');
            $request->session()->put('user_id', 'admin_' . $admin->id);
            $request->session()->put('admin_id', $admin->id);
            $request->session()->put('admin_name', $admin->name ?? 'Admin');
            $request->session()->put('admin_picture', $admin->picture);
            $request->session()->put('show_welcome_motivational', true);
            return redirect()->route('dashboard');
        }

        // Check user accounts table
        $user = DB::table('user_accounts')
            ->where('email', $validated['email'])
            ->where('schoolId', $validated['schoolId'])
            ->first();

        if ($user && Hash::check($validated['password'], $user->password)) {
            $request->session()->put('user_logged_in', true);
            $request->session()->put('user_type', 'user');
            $request->session()->put('user_id', $user->id);
            $request->session()->put('school_id', $user->schoolId);
            $request->session()->put('user_name', $user->name);
            $request->session()->put('user_email', $user->email);
            $request->session()->put('user_picture', $user->picture);
            $request->session()->put('show_welcome_motivational', true);

            // Pick a random motivational message, send it to the student's notification bell,
            // and store it in session so the welcome modal shows the same one
            $motivational = MotivationalMessage::where('archived', false)->inRandomOrder()->first();
            if ($motivational) {
                Notification::create([
                    'user_id' => $user->id,
                    'title'   => 'Daily Motivational Message',
                    'message' => "\u{201C}" . $motivational->message . "\u{201D}",
                    'type'    => 'motivational',
                    'read'    => false,
                ]);
                $request->session()->put('welcome_motivational_message', $motivational->message);
            }

            return redirect()->route('user.schedules');
        }

        // If credentials are invalid, return back with error
        return back()->withErrors(['login' => 'Invalid credentials or School ID. Please try again.'])
                     ->withInput();
    }
}
