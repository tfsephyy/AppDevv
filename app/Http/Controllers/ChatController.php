<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\ToxicWord;
use App\Services\MessageFilterService;
use Carbon\Carbon;

class ChatController extends Controller
{
    protected $messageFilter;

    public function __construct(MessageFilterService $messageFilter)
    {
        $this->messageFilter = $messageFilter;
    }
    public function index()
    {
        $chats = Chat::with('userAccount')
            ->where('reported', false)
            ->orderBy('created_at', 'asc')
            ->get();
        
        // Check user type from session
        $userType = session('user_type', 'guest');
        $isAdmin = ($userType === 'admin');
        
        // Use distinct identifier for admin vs user
        if ($isAdmin) {
            $currentUserId = 'admin_' . session('admin_id', '0');
        } else {
            $currentUserId = session('user_id', session('school_id', request()->ip()));
        }
        
        // Return different views based on user type
        if ($isAdmin) {
            $reportedCount = Chat::where('reported', true)->count();
            return view('publicChat', compact('chats', 'currentUserId', 'isAdmin', 'userType', 'reportedCount'));
        } else {
            return view('user.user-public-chat', compact('chats', 'currentUserId', 'isAdmin', 'userType'));
        }
    }

    public function store(Request $request)
    {
        \Log::info('Chat store called', ['message' => $request->message]);
        
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        // Validate message for toxic content using the new filter service
        $validationResult = $this->messageFilter->validateMessage($request->message);
        if (!$validationResult['valid']) {
            \Log::warning('Toxic content detected', ['error' => $validationResult['error']]);
            return response()->json([
                'success' => false,
                'error' => 'toxic_content',
                'message' => $validationResult['error']
            ], 400);
        }

        // Check user type from session
        $userType = session('user_type', 'guest');
        $isAdmin = ($userType === 'admin');
        
        \Log::info('User info', ['userType' => $userType, 'isAdmin' => $isAdmin, 'user_id' => session('user_id')]);
        
        // Get the correct user ID based on user type
        if ($isAdmin) {
            $userId = 'admin_' . session('admin_id', '0');
        } else {
            $userId = session('user_id', session('school_id', $request->ip()));
        }
        
        $chat = Chat::create([
            'user_id' => $userId,
            'message' => $request->message,
            'is_admin' => $isAdmin
        ]);

        \Log::info('Chat created successfully', ['chat_id' => $chat->id]);

        return response()->json(['success' => true, 'chat_id' => $chat->id]);
    }

    public function destroy($id)
    {
        $chat = Chat::findOrFail($id);
        $currentUserId = session('user_id', session('school_id', request()->ip()));
        $isAdmin = session('admin_logged_in', false);
        
        // Admin can delete any message, users can only delete their own
        if ($isAdmin || (string)$chat->user_id === (string)$currentUserId) {
            $chat->delete();
            return response()->json(['success' => true]);
        }
        
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        // Validate message for toxic content before updating
        $validationResult = $this->messageFilter->validateMessage($request->message);
        if (!$validationResult['valid']) {
            return response()->json([
                'success' => false,
                'error' => 'toxic_content',
                'message' => $validationResult['error']
            ], 400);
        }
        
        $chat = Chat::findOrFail($id);
        $isAdmin = session('admin_logged_in', false);
        $currentUserId = $isAdmin ? 'admin_' . session('admin_id', '0') : session('user_id', session('school_id', request()->ip()));
        
        // Allow admin to update any message, users can only update their own
        if ($isAdmin || (string)$chat->user_id === (string)$currentUserId) {
            $chat->message = $request->message;
            $chat->save();
            return response()->json(['success' => true]);
        }
        
        return response()->json(['error' => 'Unauthorized'], 403);
    }
    
    public function report($id)
    {
        $chat = Chat::findOrFail($id);
        $chat->reported = true;
        $chat->save();
        
        return response()->json(['success' => true]);
    }
    
    public function getReported()
    {
        $isAdmin = session('admin_logged_in', false);
        
        if (!$isAdmin) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $reportedChats = Chat::where('reported', true)->orderBy('created_at', 'desc')->get();
        return response()->json($reportedChats);
    }
    
    public function unreport($id)
    {
        $isAdmin = session('admin_logged_in', false);
        
        if (!$isAdmin) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $chat = Chat::findOrFail($id);
        $chat->reported = false;
        $chat->save();
        
        return response()->json(['success' => true]);
    }
}
