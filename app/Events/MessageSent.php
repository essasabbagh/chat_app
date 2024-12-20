<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class MessageSent implements ShouldBroadcastNow
{
    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        // Broadcast to the receiver's private channel
        return [
            // new Channel('messages'),
            new PrivateChannel('chat.' . $this->message->receiver_id), //  . $this->message->receiver_id
        ];
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->message->id,
            'message' => $this->message->message,
            'sender_id' => $this->message->sender_id,
            'receiver_id' => $this->message->receiver_id,
            'created_at' => $this->message->created_at,
        ];
    }

    // public function broadcastAs()
    // {
    //     return 'message.sent';
    // }
}



// class MessageSent implements ShouldBroadcastNow
// {
//     use Dispatchable, InteractsWithSockets, SerializesModels;

//     public Message $message;
//     /**
//      * Create a new event instance.
//      */
//     public function __construct(Message $message)
//     {
//         $this->message = $message;
//     }

//     /**
//      * Get the channels the event should broadcast on.
//      *
//      * @return array<int, \Illuminate\Broadcasting\Channel>
//      */
//     // public function broadcastOn(): PrivateChannel
//     // {
//     //     return new PrivateChannel(
//     //         'chat.' . $this->message->receiver_id,
//     //     );
//     // }

//     public function broadcastOn(): Channel|array
//     {
//         return new PrivateChannel(
//             'chat.' . $this->message->receiver_id,
//         ); // Use user ID to make it private
//     }

//     public function broadcastWith()
//     {
//         return [
//             'id' => $this->message->id,
//             'message' => $this->message->message,
//             'sender_id' => $this->message->sender_id,
//             'created_at' => $this->message->created_at
//         ];
//         // return [
//         //     'message' => $this->message,
//         //     'timestamp' => now(),
//         // ];
//     }

//     public function broadcastAs()
//     {
//         return 'message.sent';
//     }
// }
