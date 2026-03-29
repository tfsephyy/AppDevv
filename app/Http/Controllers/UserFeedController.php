<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\PostComment;
use App\Models\Admin;
use App\Models\AdminNotification;
use App\Models\UserAccount;
use App\Services\MessageFilterService;

class UserFeedController extends Controller
{
    public function index()
    {
        $userId = session('user_id', request()->ip());
        $currentUserId = $userId;
        
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
        
        return view('user.user-feed', compact('posts', 'currentUserId'));
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

        // Check for toxic content
        $filter = app(MessageFilterService::class);
        $validationResult = $filter->validateMessage($validated['comment']);
        if (!$validationResult['valid']) {
            return response()->json([
                'success' => false,
                'error' => 'toxic_content',
                'message' => $validationResult['error']
            ], 400);
        }

        $userId = session('user_id', $request->ip());

        $comment = PostComment::create([
            'post_id' => $id,
            'parent_id' => $validated['parent_id'] ?? null,
            'user_id' => $userId,
            'comment' => $validated['comment'],
        ]);

        // Notify admin that a student commented
        $userAccount = UserAccount::find(session('user_id'));
        $studentName = $userAccount ? $userAccount->name : 'A student';
        $snippet = \Illuminate\Support\Str::limit($validated['comment'], 80);
        AdminNotification::create([
            'title' => 'New Comment on Post',
            'message' => $studentName . ' commented: "' . $snippet . '"',
            'type' => 'feed_comment',
            'related_id' => $comment->id,
            'read' => false,
        ]);

        // Resolve author name for response
        $authorName = $this->resolveAuthorName($userId);

        return response()->json([
            'success' => true,
            'comment' => array_merge($comment->toArray(), [
                'author_name' => $authorName,
                'author_initials' => strtoupper(collect(explode(' ', $authorName))->map(fn($w) => substr($w, 0, 1))->take(2)->join('')),
            ])
        ]);
    }

    public function getComments($id)
    {
        $comments = PostComment::where('post_id', $id)
            ->whereNull('parent_id')
            ->with('replies')
            ->orderBy('created_at', 'desc')
            ->get();

        // Resolve author names for all comments and replies
        $comments->transform(function ($comment) {
            return $this->appendAuthorInfo($comment);
        });

        return response()->json($comments);
    }

    /**
     * Resolve author name from user_id (handles both admin and student).
     */
    private function resolveAuthorName($userId)
    {
        if ($userId && str_starts_with((string)$userId, 'admin_')) {
            $adminId = str_replace('admin_', '', $userId);
            $admin = Admin::find($adminId);
            return $admin ? $admin->name : 'Admin';
        }

        $user = UserAccount::find($userId);
        return $user ? $user->name : 'Unknown User';
    }

    /**
     * Append author_name and author_initials to a comment and its replies.
     */
    private function appendAuthorInfo($comment)
    {
        $name = $this->resolveAuthorName($comment->user_id);
        $comment->author_name = $name;
        $comment->author_initials = strtoupper(collect(explode(' ', $name))->map(fn($w) => substr($w, 0, 1))->take(2)->join(''));

        if ($comment->relationLoaded('replies')) {
            $comment->replies->transform(function ($reply) {
                return $this->appendAuthorInfo($reply);
            });
        }

        return $comment;
    }
}
