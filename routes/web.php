<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\CounselingController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\UserFeedController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UserScheduleController;
use App\Http\Controllers\UserSessionController;
use App\Http\Controllers\InformationController;

Route::get('/', function () {
    return view('landingPage');
});

Route::get('/login', function () {
    return view('loginPage');
})->name('login');

Route::get('/signup', function () {
    return view('signUp');
})->name('signup');
Route::get('/student/{id}/schedule-history', [DashboardController::class, 'studentScheduleHistory']);

Route::post('/signup', [SignUpController::class, 'store'])->name('signup.store');

Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/feed', [FeedController::class, 'index'])->name('feed');
Route::post('/feed', [FeedController::class, 'store'])->name('feed.store');
Route::post('/feed/{id}/like', [FeedController::class, 'like'])->name('feed.like');
Route::post('/feed/{id}/comment', [FeedController::class, 'comment'])->name('feed.comment');
Route::get('/feed/{id}/comments', [FeedController::class, 'getComments'])->name('feed.comments');
Route::delete('/feed/comment/{id}', [FeedController::class, 'destroyComment'])->name('feed.comment.destroy');
Route::put('/feed/comment/{id}', [FeedController::class, 'updateComment'])->name('feed.comment.update');
Route::post('/feed/{id}/archive', [FeedController::class, 'archive'])->name('feed.archive');
Route::post('/feed/{id}/unarchive', [FeedController::class, 'unarchive'])->name('feed.unarchive');
Route::put('/feed/{id}', [FeedController::class, 'update'])->name('feed.update');
Route::delete('/feed/{id}', [FeedController::class, 'destroy'])->name('feed.destroy');
Route::get('/feed-archive', [FeedController::class, 'getArchived'])->name('feed.archived');

Route::get('/counseling', [CounselingController::class, 'index'])->name('counceling');
Route::post('/counseling', [CounselingController::class, 'store'])->name('counceling.store');
Route::get('/counseling/{id}', [CounselingController::class, 'show'])->name('counceling.show');
Route::put('/counseling/{id}', [CounselingController::class, 'update'])->name('counceling.update');
Route::post('/counseling/{id}/archive', [CounselingController::class, 'archive'])->name('counceling.archive');
Route::post('/counseling/{id}/unarchive', [CounselingController::class, 'unarchive'])->name('counceling.unarchive');
Route::delete('/counseling/{id}', [CounselingController::class, 'destroy'])->name('counceling.destroy');
Route::get('/counseling-archive', [CounselingController::class, 'getArchived'])->name('counceling.archived');
Route::get('/counseling/user-schedules/{schoolId}', [CounselingController::class, 'getUserSchedules'])->name('counceling.schedules');
Route::get('/counseling/student/{userId}/history', [CounselingController::class, 'getStudentHistory'])->name('counceling.student.history');

Route::get('/public-chat', [ChatController::class, 'index'])->name('public.chat');
Route::post('/public-chat', [ChatController::class, 'store'])->name('chat.store');
Route::delete('/public-chat/{id}', [ChatController::class, 'destroy'])->name('chat.destroy');
Route::put('/public-chat/{id}', [ChatController::class, 'update'])->name('chat.update');
Route::post('/public-chat/{id}/report', [ChatController::class, 'report'])->name('chat.report');
Route::get('/public-chat/reported/list', [ChatController::class, 'getReported'])->name('chat.reported');
Route::post('/public-chat/{id}/unreport', [ChatController::class, 'unreport'])->name('chat.unreport');
Route::get('/scheduling', [ScheduleController::class, 'index'])->name('scheduling');
Route::post('/scheduling', [ScheduleController::class, 'store'])->name('scheduling.store');
Route::get('/scheduling/booked-slots', [ScheduleController::class, 'getBookedSlots'])->name('scheduling.booked');
Route::get('/scheduling/user-accounts', [ScheduleController::class, 'getUserAccounts'])->name('scheduling.users');
Route::get('/scheduling/pending-count', [ScheduleController::class, 'pendingCount'])->name('scheduling.pending-count');
Route::get('/admin/notifications', [ScheduleController::class, 'adminNotifications'])->name('admin.notifications');
Route::post('/admin/notifications/read-all', [ScheduleController::class, 'markAllAdminNotificationsRead'])->name('admin.notifications.read-all');
Route::post('/admin/notifications/{id}/read', [ScheduleController::class, 'adminNotificationRead'])->name('admin.notifications.read');
Route::get('/admin/notifications/unread-count', [ScheduleController::class, 'adminUnreadCount'])->name('admin.notifications.unread-count');
Route::get('/scheduling/{id}', [ScheduleController::class, 'show'])->name('scheduling.show');
Route::post('/scheduling/{id}/complete', [ScheduleController::class, 'complete'])->name('scheduling.complete');
Route::post('/scheduling/{id}/accept', [ScheduleController::class, 'accept'])->name('scheduling.accept');
Route::post('/scheduling/{id}/deny', [ScheduleController::class, 'deny'])->name('scheduling.deny');
Route::post('/scheduling/{id}/reschedule', [ScheduleController::class, 'reschedule'])->name('scheduling.reschedule');
Route::post('/scheduling/{id}/unarchive', [ScheduleController::class, 'unarchive'])->name('scheduling.unarchive');
Route::delete('/scheduling/{id}', [ScheduleController::class, 'destroy'])->name('scheduling.destroy');
Route::get('/scheduling-archive', [ScheduleController::class, 'archive'])->name('scheduling.archive');

// User routes
Route::get('/user/journal', [JournalController::class, 'index'])->name('user.journal');
Route::post('/user/journal', [JournalController::class, 'store'])->name('user.journal.store');
Route::get('/user/journal/{id}', [JournalController::class, 'show'])->name('user.journal.show');
Route::put('/user/journal/{id}', [JournalController::class, 'update'])->name('user.journal.update');
Route::post('/user/journal/{id}/archive', [JournalController::class, 'archive'])->name('user.journal.archive');
Route::post('/user/journal/{id}/unarchive', [JournalController::class, 'unarchive'])->name('user.journal.unarchive');
Route::delete('/user/journal/{id}', [JournalController::class, 'destroy'])->name('user.journal.destroy');
Route::post('/user/journal/{id}/post', [JournalController::class, 'post'])->name('user.journal.post');
Route::get('/user/journal-list', [JournalController::class, 'getMyJournals'])->name('user.journal.list');
Route::get('/user/journal-archive', [JournalController::class, 'getArchived'])->name('user.journal.archived');
Route::get('/user/journal-public', [JournalController::class, 'getPublicJournals'])->name('user.journal.public');
Route::post('/user/journal/{id}/toggle-public', [JournalController::class, 'togglePublic'])->name('user.journal.toggle-public');
Route::post('/user/journal/{id}/like', [JournalController::class, 'likeJournal'])->name('user.journal.like');
Route::post('/user/journal/{id}/comment', [JournalController::class, 'addComment'])->name('user.journal.comment');
Route::delete('/user/journal/comment/{id}', [JournalController::class, 'deleteComment'])->name('user.journal.comment.delete');

Route::get('/user/schedules', [UserScheduleController::class, 'index'])->name('user.schedules');
Route::post('/user/schedules', [UserScheduleController::class, 'store'])->name('user.schedules.store');
Route::put('/user/schedules/{id}', [UserScheduleController::class, 'update'])->name('user.schedules.update');
Route::delete('/user/schedules/{id}', [UserScheduleController::class, 'destroy'])->name('user.schedules.destroy');
Route::get('/user/schedules/booked-slots', [UserScheduleController::class, 'getBookedSlots'])->name('user.schedules.booked');
Route::post('/user/schedules/{id}/accept-reschedule', [UserScheduleController::class, 'acceptReschedule'])->name('user.schedules.accept-reschedule');
Route::post('/user/schedules/{id}/cancel-reschedule', [UserScheduleController::class, 'cancelReschedule'])->name('user.schedules.cancel-reschedule');
Route::post('/user/schedules/{id}/cancel', [UserScheduleController::class, 'cancel'])->name('user.schedules.cancel');
Route::post('/user/schedules/{id}/request-reschedule', [UserScheduleController::class, 'requestReschedule'])->name('user.schedules.request-reschedule');
Route::post('/scheduling/{id}/accept-student-reschedule', [ScheduleController::class, 'acceptStudentReschedule'])->name('scheduling.accept-student-reschedule');
Route::post('/scheduling/{id}/deny-student-reschedule', [ScheduleController::class, 'denyStudentReschedule'])->name('scheduling.deny-student-reschedule');

Route::get('/user/sessions', [UserSessionController::class, 'index'])->name('user.sessions');

Route::get('/user/feed', [UserFeedController::class, 'index'])->name('user.feed');
Route::post('/user/feed/{id}/like', [UserFeedController::class, 'like'])->name('user.feed.like');
Route::post('/user/feed/{id}/comment', [UserFeedController::class, 'comment'])->name('user.feed.comment');
Route::get('/user/feed/{id}/comments', [UserFeedController::class, 'getComments'])->name('user.feed.comments');
Route::delete('/user/feed/comment/{id}', [FeedController::class, 'destroyComment'])->name('user.feed.comment.destroy');
Route::match(['post','put'], '/user/feed/comment/{id}', [FeedController::class, 'updateComment'])->name('user.feed.comment.update');

Route::get('/user/information', [InformationController::class, 'index'])->name('user.information');

Route::get('/user/public-chat', function () {
    $chats = \App\Models\Chat::with('userAccount')
        ->where('reported', false)
        ->orderBy('created_at', 'asc')
        ->get();
    $currentUserId = session('user_id', session('school_id', request()->ip()));
    $isAdmin = false;
    $userType = session('user_type', 'user');
    return view('user.user-public-chat', compact('chats', 'currentUserId', 'isAdmin', 'userType'));
})->name('user.public.chat');

Route::get('/user/settings', function () {
    return view('user.user-settings');
})->name('user.settings');

Route::get('/user/profile', [App\Http\Controllers\UserProfileController::class, 'show'])->name('user.profile.show');
Route::post('/user/profile', [App\Http\Controllers\UserProfileController::class, 'update'])->name('user.profile.update');

Route::get('/user/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('user.notifications');
Route::post('/user/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('user.notifications.read');
Route::post('/user/notifications/read-all', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('user.notifications.readAll');
Route::get('/user/notifications/unread-count', [App\Http\Controllers\NotificationController::class, 'getUnreadCount'])->name('user.notifications.unreadCount');

Route::get('/admin/profile', [App\Http\Controllers\AdminProfileController::class, 'show'])->name('admin.profile.show');
Route::post('/admin/profile', [App\Http\Controllers\AdminProfileController::class, 'update'])->name('admin.profile.update');

Route::get('/admin/journal', [JournalController::class, 'adminIndex'])->name('admin.journal');

Route::get('/motivational', [App\Http\Controllers\MotivationalMessageController::class, 'index'])->name('motivational');
Route::get('/motivational/archive', [App\Http\Controllers\MotivationalMessageController::class, 'archive'])->name('motivational.archive');
Route::post('/motivational', [App\Http\Controllers\MotivationalMessageController::class, 'store'])->name('motivational.store');
Route::get('/motivational/{id}', [App\Http\Controllers\MotivationalMessageController::class, 'show'])->name('motivational.show');
Route::put('/motivational/{id}', [App\Http\Controllers\MotivationalMessageController::class, 'update'])->name('motivational.update');
Route::post('/motivational/{id}/archive', [App\Http\Controllers\MotivationalMessageController::class, 'archiveMessage'])->name('motivational.archive.message');
Route::post('/motivational/{id}/unarchive', [App\Http\Controllers\MotivationalMessageController::class, 'unarchive'])->name('motivational.unarchive');
Route::delete('/motivational/{id}', [App\Http\Controllers\MotivationalMessageController::class, 'destroy'])->name('motivational.destroy');
Route::get('/motivational-random', [App\Http\Controllers\MotivationalMessageController::class, 'random'])->name('motivational.random');

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
