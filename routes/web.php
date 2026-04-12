<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\NewsletterController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Newsletter Routes
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::post('/newsletter/unsubscribe', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');
Route::get('/newsletter/unsubscribe/{email}', [NewsletterController::class, 'unsubscribeGet'])->name('newsletter.unsubscribe.get');
Route::get('/newsletter/unsubscribed', [NewsletterController::class, 'unsubscribed'])->name('newsletter.unsubscribed');
Route::get('/newsletter/verify/{token}', [NewsletterController::class, 'verify'])->name('newsletter.verify');

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');
Route::post('/posts/{post:slug}/comments', [PostController::class, 'storeComment'])->name('posts.comments.store');
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'sendContact'])->name('contact.send');
Route::get('/pages/{page:slug}', [PageController::class, 'show'])->name('pages.show');
Route::get('/privacy-policy', fn() => view('public.pages.privacy-policy'))->name('privacy-policy');
Route::get('/terms', fn() => view('public.pages.terms'))->name('terms');

// Forum Routes
Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
Route::get('/forum/create', [ForumController::class, 'create'])->name('forum.create');
Route::post('/forum', [ForumController::class, 'store'])->name('forum.store');
Route::get('/forum/{slug}', [ForumController::class, 'show'])->name('forum.show');
Route::post('/forum/{slug}/reply', [ForumController::class, 'reply'])->name('forum.reply');
Route::post('/forum/{slug}/reply/ajax', [ForumController::class, 'replyAjax'])->name('forum.reply.ajax');

// Auth Routes (Breeze)
require __DIR__ . '/auth.php';

// Profile Routes (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('system', [\App\Http\Controllers\Admin\SystemController::class, 'index'])->name('system');
    Route::post('system/clear-cache', [\App\Http\Controllers\Admin\SystemController::class, 'clearCache'])->name('system.clear-cache');

    // Posts - place custom routes BEFORE resource to take precedence
    Route::get('get-post-data/{post}', [\App\Http\Controllers\Admin\PostController::class, 'editData'])->name('posts.get-data');
    Route::resource('posts', \App\Http\Controllers\Admin\PostController::class);

    // Categories
    Route::get('get-category-data/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'editData'])->name('categories.get-data');
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['show']);

    // Pages
    Route::get('get-page-data/{page}', [\App\Http\Controllers\Admin\PageController::class, 'editData'])->name('pages.get-data');
    Route::resource('pages', \App\Http\Controllers\Admin\PageController::class)->except(['show']);

    // Comments
    Route::get('comments', [\App\Http\Controllers\Admin\CommentController::class, 'index'])->name('comments.index');
    Route::patch('comments/{comment}/approve', [\App\Http\Controllers\Admin\CommentController::class, 'approve'])->name('comments.approve');
    Route::patch('comments/{comment}/reject', [\App\Http\Controllers\Admin\CommentController::class, 'reject'])->name('comments.reject');
    Route::delete('comments/{comment}', [\App\Http\Controllers\Admin\CommentController::class, 'destroy'])->name('comments.destroy');

    // Users
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->except(['show', 'create', 'edit']);

    // Announcements
    Route::resource('announcements', \App\Http\Controllers\Admin\AnnouncementController::class)->except(['show', 'create', 'edit']);

    // Forum
    Route::get('forum/topics', [\App\Http\Controllers\Admin\ForumController::class, 'topics'])->name('forum.topics');
    Route::delete('forum/topics/{topic}', [\App\Http\Controllers\Admin\ForumController::class, 'topicDestroy'])->name('forum.topics.destroy');
    Route::patch('forum/topics/{topic}/toggle', [\App\Http\Controllers\Admin\ForumController::class, 'topicToggle'])->name('forum.topics.toggle');
    Route::get('forum/replies', [\App\Http\Controllers\Admin\ForumController::class, 'replies'])->name('forum.replies');
    Route::delete('forum/replies/{reply}', [\App\Http\Controllers\Admin\ForumController::class, 'replyDestroy'])->name('forum.replies.destroy');

    // Settings
    Route::get('settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
    Route::post('settings/sync-about', [\App\Http\Controllers\Admin\SettingController::class, 'syncAboutPage'])->name('settings.sync-about');
});
