<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\UserAccount;

class SignUpController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'schoolId' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user_accounts,email',
            'program' => 'required|string|max:255',
            'program_other' => 'required_if:program,Others|nullable|string|max:255',
            'year' => 'required|in:1,2,3,4',
            'section' => 'required|in:1,2,3,4',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'confirmed',
            ],
        ]);

        // If program is 'Others', use the program_other value
        $program = $validated['program'] === 'Others' ? $validated['program_other'] : $validated['program'];

        UserAccount::create([
            'schoolId' => $validated['schoolId'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'program' => $program,
            'year' => $validated['year'],
            'section' => $validated['section'],
            'password' => Hash::make($validated['password'])
        ]);

        Session::flash('success', 'Account created successfully!');

        return redirect()->route('signup');
    }
}
