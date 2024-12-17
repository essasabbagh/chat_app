<?php

namespace App\Console\Commands;

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

        MessageSent::dispatch($message);

    }
}
