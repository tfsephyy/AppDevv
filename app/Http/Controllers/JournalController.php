<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Journal;
use App\Models\Post;
use App\Models\JournalLike;
use App\Models\JournalComment;
use App\Models\UserAccount;
use Illuminate\Support\Facades\Cache;

class JournalController extends Controller
{
    public function index()
    {
        $userId = session('user_id', request()->ip());
        
        $journals = Journal::where('user_id', $userId)
            ->where('archived', false)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('user.user-journal', compact('journals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'images.*' => 'nullable|image|max:5120',
            'is_public' => 'nullable|boolean',
        ]);

        $userId = session('user_id', request()->ip());
        
        // Handle image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('journal-images', 'public');
                $imagePaths[] = $path;
            }
        }

        $isPublic = $request->input('is_public', false);
        
        Journal::create([
            'user_id' => $userId,
            'title' => $validated['title'],
            'content' => $validated['content'],
            'images' => $imagePaths,
            'is_public' => $isPublic,
        ]);

        // Invalidate public journals cache if this journal is public
        if ($isPublic) {
            Cache::put('public_journals_invalidation', time(), 3600);
        }

        return response()->json(['success' => true, 'message' => 'Journal saved successfully!']);
    }

    public function show($id)
    {
        $journal = Journal::findOrFail($id);
        return response()->json($journal);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'images.*' => 'nullable|image|max:5120',
        ]);

        $journal = Journal::findOrFail($id);
        
        // Handle image uploads
        $imagePaths = $journal->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('journal-images', 'public');
                $imagePaths[] = $path;
            }
            $validated['images'] = $imagePaths;
        }
        
        $journal->update($validated);

        return response()->json(['success' => true, 'message' => 'Journal updated successfully!']);
    }

    public function archive($id)
    {
        $userId = session('user_id', request()->ip());
        $journal = Journal::where('id', $id)->where('user_id', $userId)->firstOrFail();
        $journal->update(['archived' => true]);
        
        return response()->json(['success' => true]);
    }

    public function getArchived()
    {
        $userId = session('user_id', request()->ip());
        
        $journals = Journal::where('user_id', $userId)
            ->where('archived', true)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json($journals);
    }

    public function unarchive($id)
    {
        $userId = session('user_id', request()->ip());
        $journal = Journal::where('id', $id)->where('user_id', $userId)->firstOrFail();
        $journal->update(['archived' => false]);
        
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $userId = session('user_id', request()->ip());
        $journal = Journal::where('id', $id)->where('user_id', $userId)->firstOrFail();
        $journal->delete();
        
        return response()->json(['success' => true]);
    }

    public function post($id)
    {
        $userId = session('user_id', request()->ip());
        $journal = Journal::where('id', $id)->where('user_id', $userId)->firstOrFail();

        // Create a post from the journal
        Post::create([
            'user_id' => $userId,
            'content' => "📔 {$journal->title}\n\n{$journal->content}",
            'images' => [],
        ]);

        // Mark journal as posted and public
        $journal->update([
            'is_posted' => true,
            'is_public' => true
        ]);

        // Invalidate public journals cache since we made a journal public
        Cache::put('public_journals_invalidation', time(), 3600);

        return response()->json(['success' => true, 'message' => 'Journal posted to feed successfully!']);
    }

    public function getPublicJournals()
    {
        $userId = session('user_id') ?? request()->ip(); // Fallback to IP if no session

        // Use a cache key that includes a global invalidation timestamp
        $invalidationKey = Cache::get('public_journals_invalidation', 0);
        $cacheKey = 'public_journals_' . $userId . '_' . $invalidationKey;

        try {
            $journals = Cache::remember($cacheKey, 300, function () use ($userId) {
                // Get only the most recent 10 public journals for performance
                $journals = Journal::where('is_public', true)
                    ->where('archived', false)
                    ->with(['likes', 'comments'])
                    ->orderBy('created_at', 'desc')
                    ->limit(10) // Limit for performance
                    ->get()
                    ->map(function ($journal) use ($userId) {
                        // Try to get user from UserAccount
                        $user = UserAccount::find($journal->user_id);
                        $userName = $user ? $user->name : 'Anonymous';
                        $userInitials = strtoupper(substr($userName, 0, 2));

                        return [
                            'id' => $journal->id,
                            'title' => $journal->title,
                            'content' => $journal->content,
                            'images' => $journal->images ?? [],
                            'created_at' => $journal->created_at->format('M d, Y • g:i A'),
                            'user_name' => $userName,
                            'user_initials' => $userInitials,
                            'likes_count' => $journal->likes->count(),
                            'comments_count' => $journal->comments->count(),
                            'is_liked' => $journal->likes->where('user_id', $userId)->count() > 0,
                            'comments' => $journal->comments->take(5)->map(function ($comment) use ($userId) { // Limit comments for performance
                                return [
                                    'id' => $comment->id,
                                    'user_name' => $comment->user_name ?? 'User',
                                    'comment' => $comment->comment,
                                    'created_at' => $comment->created_at->diffForHumans(),
                                    'is_own' => $comment->user_id == $userId,
                                ];
                            })->values(),
                        ];
                    });

                return $journals;
            });

            // Log for debugging
            \Log::info('Public journals loaded', [
                'user_id' => $userId,
                'count' => count($journals),
                'cache_key' => $cacheKey
            ]);

            return response()->json($journals);

        } catch (\Exception $e) {
            \Log::error('Error loading public journals', [
                'error' => $e->getMessage(),
                'user_id' => $userId
            ]);

            // Return empty array on error to prevent frontend issues
            return response()->json([]);
        }
    }

    public function togglePublic($id)
    {
        $userId = session('user_id', request()->ip());
        $journal = Journal::where('id', $id)->where('user_id', $userId)->firstOrFail();
        $journal->update(['is_public' => !$journal->is_public]);

        // Invalidate all public journals cache by updating the invalidation timestamp
        Cache::put('public_journals_invalidation', time(), 3600); // Cache for 1 hour

        return response()->json([
            'success' => true,
            'is_public' => $journal->is_public,
            'message' => $journal->is_public ? 'Journal is now public' : 'Journal is now private'
        ]);
    }

    public function likeJournal($id)
    {
        $userId = session('user_id', request()->ip());
        $journal = Journal::findOrFail($id);
        
        $existingLike = JournalLike::where('journal_id', $id)
            ->where('user_id', $userId)
            ->first();
        
        if ($existingLike) {
            $existingLike->delete();
            $liked = false;
        } else {
            JournalLike::create([
                'journal_id' => $id,
                'user_id' => $userId,
            ]);
            $liked = true;
        }
        
        return response()->json([
            'success' => true,
            'liked' => $liked,
            'likes_count' => $journal->likes()->count()
        ]);
    }

    public function addComment(Request $request, $id)
    {
        $validated = $request->validate([
            'comment' => 'required|string|max:1000',
        ]);
        
        $userId = session('user_id', request()->ip());
        $userName = session('user_name', 'User');
        
        $comment = JournalComment::create([
            'journal_id' => $id,
            'user_id' => $userId,
            'user_name' => $userName,
            'comment' => $validated['comment'],
        ]);
        
        return response()->json([
            'success' => true,
            'comment' => [
                'id' => $comment->id,
                'user_name' => $comment->user_name,
                'comment' => $comment->comment,
                'created_at' => $comment->created_at->diffForHumans(),
                'is_own' => true,
            ]
        ]);
    }

    public function deleteComment($id)
    {
        $userId = session('user_id', request()->ip());
        $comment = JournalComment::findOrFail($id);
        
        // Only allow deleting own comments
        if ($comment->user_id != $userId) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $comment->delete();
        
        return response()->json(['success' => true]);
    }
}

