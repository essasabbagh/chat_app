<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Message;
use App\Events\OrderEvent;
use App\Events\MessageSent;
use Illuminate\Console\Command;
use function Laravel\Prompts\text;

class SendMessageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a message to chat';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $name = text(
        //     label: 'Whats Your name',
        //     required: true,
        // );
        $message = text(
            label: 'Whats Your message',
            required: true,
        );

        // MessageSent::dispatch(Message::find(19));

        $msg = Message::create(
            [
                'sender_id' => 1,
                'receiver_id' => 22,
                'message' => $message,
            ]
        );
        broadcast(new MessageSent(
            $msg
        ));

        // broadcast(new OrderEvent(
        //     User::find(22),
        // ));

    }
}
