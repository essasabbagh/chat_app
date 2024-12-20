<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::routes(['middleware' => ['auth:sanctum']]);

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });


Broadcast::channel('chat.{userId}', function (User $user, $userId) {
    // Ensure the authenticated user can only access their own private channel
    return (int) $user->id === (int) $userId;
    // return true; // Public channel, anyone can listen

});

Broadcast::channel('messages', function () {
    return true; // Public channel, anyone can listen
});



