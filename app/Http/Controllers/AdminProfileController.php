<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Storage;

class AdminProfileController extends Controller
{
    public function show()
    {
        $adminId = session('admin_id');
        $admin = Admin::find($adminId);

        if (!$admin) {
            return response()->json(['error' => 'Admin not found'], 404);
        }

        return response()->json([
            'name' => $admin->name,
            'schoolId' => $admin->schoolId,
            'email' => $admin->email,
            'picture' => $admin->picture ?? null,
        ]);
    }

    public function update(Request $request)
    {
        $adminId = session('admin_id');
        $admin = Admin::find($adminId);

        if (!$admin) {
            return response()->json(['error' => 'Admin not found'], 404);
        }

        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:admin_table,email,' . $admin->id,
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Handle picture upload
        if ($request->hasFile('picture')) {
            // Delete old picture if exists
            if ($admin->picture && Storage::exists('public/' . $admin->picture)) {
                Storage::delete('public/' . $admin->picture);
            }

            $picturePath = $request->file('picture')->store('admin_pictures', 'public');
            $data['picture'] = $picturePath;
        }

        $admin->update($data);

        // Update session data
        session(['admin_name' => $data['name'] ?? 'Admin']);
        if (isset($data['picture'])) {
            session(['admin_picture' => $data['picture']]);
        }

        return response()->json(['success' => true]);
    }
}
