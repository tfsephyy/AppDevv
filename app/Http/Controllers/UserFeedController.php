<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\PostComment;

class UserFeedController extends Controller
{
    public function index()
    {
        $userId = session('user_id', request()->ip());
        
        $posts = Post::where('archived', false)
            ->withCount(['likes', 'allComments'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($post) use ($userId) {
                $post->user_has_liked = PostLike::where('post_id', $post->id)
                    ->where('user_id', $userId)
                    ->exists();
                return $post;
            });
        
        return view('user.user-feed', compact('posts'));
    }

    public function like(Request $request, $id)
    {
        $userId = session('user_id') ?? $request->ip();
        
        $like = PostLike::where('post_id', $id)
            ->where('user_id', $userId)
            ->first();
        
        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            PostLike::create([
                'post_id' => $id,
                'user_id' => $userId,
            ]);
            $liked = true;
        }
        
        $likesCount = PostLike::where('post_id', $id)->count();
        
        return response()->json([
            'liked' => $liked,
            'likes_count' => $likesCount
        ]);
    }

    public function comment(Request $request, $id)
    {
        $validated = $request->validate([
            'comment' => 'required|string',
            'parent_id' => 'nullable|exists:post_comments,id',
        ]);

        $userId = session('user_id', $request->ip());

        $comment = PostComment::create([
            'post_id' => $id,
            'parent_id' => $validated['parent_id'] ?? null,
            'user_id' => $userId,
            'comment' => $validated['comment'],
        ]);

        return response()->json([
            'success' => true,
            'comment' => $comment
        ]);
    }

    public function getComments($id)
    {
        $comments = PostComment::where('post_id', $id)
            ->whereNull('parent_id')
            ->with('replies')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json($comments);
    }
}
