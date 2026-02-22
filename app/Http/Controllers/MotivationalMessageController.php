<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MotivationalMessage;

class MotivationalMessageController extends Controller
{
    public function index()
    {
        $messages = MotivationalMessage::where('archived', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('motivational', compact('messages'));
    }

    public function archive()
    {
        $messages = MotivationalMessage::where('archived', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('motivational-archive', compact('messages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        MotivationalMessage::create([
            'message' => $validated['message'],
            'archived' => false,
        ]);

        return redirect()->route('motivational')->with('success', 'Motivational message added successfully!');
    }

    public function show($id)
    {
        $message = MotivationalMessage::findOrFail($id);
        return response()->json($message);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = MotivationalMessage::findOrFail($id);
        $message->update([
            'message' => $validated['message'],
        ]);

        return response()->json(['success' => true]);
    }

    public function archiveMessage($id)
    {
        $message = MotivationalMessage::findOrFail($id);
        $message->update(['archived' => true]);

        return response()->json(['success' => true]);
    }

    public function unarchive($id)
    {
        $message = MotivationalMessage::findOrFail($id);
        $message->update(['archived' => false]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $message = MotivationalMessage::findOrFail($id);
        $message->delete();

        return response()->json(['success' => true]);
    }
}
