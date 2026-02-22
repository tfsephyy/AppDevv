<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return response()->json(['error' => 'User not logged in'], 401);
        }
        
        $notifications = Notification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json($notifications);
    }
    
    public function markAsRead($id)
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return response()->json(['error' => 'User not logged in'], 401);
        }
        
        $notification = Notification::where('id', $id)
            ->where('user_id', $userId)
            ->first();
        
        if (!$notification) {
            return response()->json(['error' => 'Notification not found'], 404);
        }
        
        $notification->read = true;
        $notification->save();
        
        return response()->json(['success' => true]);
    }
    
    public function markAllAsRead()
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return response()->json(['error' => 'User not logged in'], 401);
        }
        
        Notification::where('user_id', $userId)
            ->where('read', false)
            ->update(['read' => true]);
        
        return response()->json(['success' => true]);
    }
    
    public function getUnreadCount()
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return response()->json(['count' => 0]);
        }
        
        $count = Notification::where('user_id', $userId)
            ->where('read', false)
            ->count();
        
        return response()->json(['count' => $count]);
    }
}
