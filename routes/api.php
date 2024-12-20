<?php

use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\MessageController;

Route::get('/', function () {
    return 'Hi';
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/users', [UserController::class, 'index']);

    // Route to get messages between two users
    Route::get('/messages/{receiverId}', [MessageController::class, 'getMessages']);
    Route::post('/send-message', [MessageController::class, 'sendMessage']);
});

Route::middleware('auth:sanctum')->post(
    '/broadcasting/auth',
    function (Request $request) {
        // Validate the incoming request
        try {

            // channel name will be something like private-room-231 where 231 is accountId
            $socketId = $request->input('socket_id');
            $channelName = $request->input('channel_name');


            // this generates the required format for the response
            $stringToAuth = $socketId . ':' . $channelName;
            $hashed = hash_hmac('sha256', $stringToAuth, env('REVERB_APP_SECRET'));

            return new JsonResponse(['auth' => env('REVERB_APP_KEY') . ':' . $hashed]);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Unauthorized',
                'th' => $th
            ], 403);

        }
    }
);

// Route::post('/send-message', function (Illuminate\Http\Request $request) {
//     $request->validate([
//         'message' => 'required|string', // Ensure 'message' is present
//     ]);

//     // broadcast(new MessageSent($request->message));
//     // Triggering the event
//     // Broadcast::event(new MessageSent([
//     //     'message' => 'Hello World!',
//     //     'user' => ['id' => 1, 'name' => 'John Doe'],
//     // ]));
//     MessageSent::dispatch($request->message);
//     return response()->json(['status' => 'Message broadcasted!']);
// });

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
