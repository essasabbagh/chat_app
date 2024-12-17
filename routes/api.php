<?php

use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;

Route::get('/', function () {
    return 'Hi';
});
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/send-message', function (Illuminate\Http\Request $request) {
    $request->validate([
        'message' => 'required|string', // Ensure 'message' is present
    ]);

    // broadcast(new MessageSent($request->message));
    // Triggering the event
    // Broadcast::event(new MessageSent([
    //     'message' => 'Hello World!',
    //     'user' => ['id' => 1, 'name' => 'John Doe'],
    // ]));
    MessageSent::dispatch($request->message);
    return response()->json(['status' => 'Message broadcasted!']);
});

// Route::post('/send-message', function (Request $request) {
//     // Validate the incoming request
//     $validated = $request->validate([
//         'message' => 'required|string',
//         'user' => 'required|array', // Expecting user information as an array
//         'user.id' => 'required|integer',
//         'user.name' => 'required|string',
//     ]);

//     // Broadcast the event with the validated data
//     broadcast(new MessageSent($validated))->toOthers();

//     // Return a response to indicate success
//     return response()->json(['status' => 'Message broadcasted successfully!']);
// });
