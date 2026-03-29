<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\PostComment;
use App\Models\Admin;
use App\Models\Notification;
use App\Models\UserAccount;
use App\Services\MessageFilterService;
use Illuminate\Support\Facades\Storage;

class FeedController extends Controller
{
    public function index()
    {
        $isAdmin = session('admin_logged_in', false);
        $isUser = session('user_logged_in', false);
        
        // Get proper user_id based on user type
        if ($isAdmin) {
            $userId = 'admin_' . session('admin_id', '0');
        } else {
            $userId = session('user_id', request()->ip());
        }
        
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
        
        // Debug: Log which view we're returning
        \Log::info('Feed Controller - isAdmin: ' . ($isAdmin ? 'true' : 'false') . ', isUser: ' . ($isUser ? 'true' : 'false'));
        
        // Return different views based on user type
        if ($isAdmin) {
            \Log::info('Returning admin feed view');
            return view('feed', compact('posts'));
        } else {
            \Log::info('Returning user feed view');
            return view('user.user-feed', compact('posts'));
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'images.*' => 'nullable|image|max:5120',
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('posts', 'public');
                $images[] = $path;
            }
        }

        $post = Post::create([
            'user_id' => session('user_id'),
            'content' => $validated['content'],
            'images' => $images,
        ]);

        // If admin posted, notify all students
        if (session('admin_logged_in')) {
            $allStudents = UserAccount::all();
            $snippet = \Illuminate\Support\Str::limit($validated['content'], 80);
            foreach ($allStudents as $student) {
                Notification::create([
                    'user_id' => $student->id,
                    'title' => 'New Post from Admin',
                    'message' => 'Admin posted: "' . $snippet . '"',
                    'type' => 'feed_post',
                    'related_id' => $post->id,
                    'read' => false,
                ]);
            }
        }

        return redirect()->route('feed')->with('success', 'Post created successfully!');
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

        // Determine user identity consistently
        if (session('admin_logged_in')) {
            $userId = 'admin_' . session('admin_id');
        } else {
            $userId = session('user_id', $request->ip());
        }

        $comment = PostComment::create([
            'post_id' => $id,
            'parent_id' => $validated['parent_id'] ?? null,
            'user_id' => $userId,
            'comment' => $validated['comment'],
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

    public function archive($id)
    {
        $post = Post::findOrFail($id);
        $post->update(['archived' => true]);
        
        return response()->json(['success' => true]);
    }

    public function getArchived()
    {
        $posts = Post::where('archived', true)
            ->withCount(['likes', 'allComments'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json($posts);
    }

    public function unarchive($id)
    {
        $post = Post::findOrFail($id);
        $post->update(['archived' => false]);
        
        return response()->json(['success' => true]);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        
        $validated = $request->validate([
            'content' => 'required|string',
            'images.*' => 'nullable|image|max:5120',
            'keep_images' => 'nullable|array',
        ]);

        // Handle images
        $existingImages = $post->images ?? [];
        $keepImages = $request->input('keep_images', []);
        
        // Remove images that are not in keep_images
        $imagesToDelete = array_diff($existingImages, $keepImages);
        foreach ($imagesToDelete as $image) {
            Storage::disk('public')->delete($image);
        }
        
        // Start with kept images
        $images = $keepImages;
        
        // Add new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('posts', 'public');
                $images[] = $path;
            }
        }

        $post->update([
            'content' => $validated['content'],
            'images' => $images,
        ]);

        return response()->json(['success' => true, 'post' => $post]);
    }


    public function destroyComment($id)
    {
        $comment = PostComment::findOrFail($id);
        
        // Delete all replies first
        PostComment::where('parent_id', $id)->delete();
        
        // Delete the comment
        $comment->delete();
        
        return response()->json(['success' => true]);
    }

    public function updateComment(Request $request, $id)
    {
        $validated = $request->validate([
            'comment' => 'required|string',
        ]);

        $comment = PostComment::findOrFail($id);

        $isAdmin = session('admin_logged_in', false);
        $currentUserId = $isAdmin ? 'admin_' . session('admin_id') : session('user_id', $request->ip());

        // Allow admin or owner to update
        if ($isAdmin || (string)$comment->user_id === (string)$currentUserId) {
            $comment->comment = $validated['comment'];
            $comment->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        
        // Delete images from storage
        if ($post->images) {
            foreach ($post->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }
        
        $post->delete();
        
        return response()->json(['success' => true]);
    }
}
