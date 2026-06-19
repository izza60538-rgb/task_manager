<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Jobs\SendWelcomeEmail;
use App\Jobs\ProcessTask;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Notifications\TaskNotification;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::resource('tasks', TaskController::class);
});

Route::get('/send-email', function () {
    SendWelcomeEmail::dispatch();
    return "Job Added to Queue";
});

Route::get('/test-queue', function () {
    ProcessTask::dispatch();    
    return 'Job added to queue';
});

Route::get('/cache-test', function () {
    $users = Cache::remember(
        'user_count',
        60,
        function () {
            return \App\Models\User::count();
        }
    );
    return "Total Users: " . $users;
});

Route::get('/cache-clear', function () {
    Cache::forget('user_count');
    return 'Cache Cleared';
});

Route::get('/notify', function () {
    $user = User::first();
    $user->notify(new TaskNotification());
    return 'Notification Sent!';
});

Route::get('/error-test', function () {
   try {
    DB::table('non_existing_table')->get();
} catch (\Exception $e) {
    return "Something went wrong!";
}
});

Route::middleware('auth')->group(function () {

    Route::resource('tasks', TaskController::class);

    Route::get('/tasks-trash', [TaskController::class, 'trash'])
    ->name('tasks.trash');

    Route::post('/tasks/{id}/restore', [TaskController::class, 'restore'])
    ->name('tasks.restore');

    Route::delete('/tasks/{id}/force-delete', [TaskController::class, 'forceDelete'])
    ->name('tasks.forceDelete');
});