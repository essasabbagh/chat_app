<?php

use App\Models\User;
use App\Models\Message;
use App\Events\OrderEvent;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hi', function () {
    broadcast(new OrderEvent(
        User::find(22),
    ));
    // $msg = Message::create(
    //     [
    //         'sender_id' => 1,
    //         'receiver_id' => 22,
    //         'message' => 'Hello, how are you?',
    //     ]
    // );
    // broadcast(new MessageSent(
    //     $msg
    // ));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
