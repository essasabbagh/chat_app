<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

// Message Controller
class MessageController extends Controller
{

    public function sendMessage(Request $request)
    {

        try {
            $message = Message::create([
                'sender_id' => auth()->id(),
                'receiver_id' => $request->receiver_id,
                'message' => $request->message
            ]);

            // Broadcast the message
            broadcast(new MessageSent($message))->toOthers();

            return response()->json($message);
        } catch (\Exceptions $e) {
        // } catch (\Throwable $th) {
            return response()->json(['errors' => $e->getMessage()], status: 400);
        }
    }
    // public function sendMessage(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'receiver_id' => 'required|exists:users,id',
    //         'message' => 'required|string'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     $message = Message::create([
    //         'sender_id' => auth()->id(),
    //         'receiver_id' => $request->receiver_id,
    //         'message' => $request->message
    //     ]);

    //     // Broadcast message
    //     // MessageSent::dispatch($message)->toOthers();
    //     broadcast(new MessageSent($message))->toOthers();

    //     return response()->json($message);
    // }

    public function getMessages($receiverId)
    {
        $messages = Message::where(function ($query) use ($receiverId) {
            $query->where('sender_id', operator: auth()->id())
                ->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($receiverId) {
            $query->where('sender_id', $receiverId)
                ->where('receiver_id', auth()->id());
        })->orderBy('created_at')->get();

        return response()->json($messages);
    }
}
