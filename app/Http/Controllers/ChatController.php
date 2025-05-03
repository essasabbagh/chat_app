<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Log;
use Cloudstudio\Ollama\Facades\Ollama;
use Laravel\Prompts\Output\BufferedConsoleOutput;

class ChatController extends Controller
{
    public function __construct()
    {
        // $this->documentation = "Your project documentation content here...";
    }

    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $userMessage = $request->input('message');

        // Debug log the incoming message
        Log::info('Incoming chat message:', ['message' => $userMessage]);

        // Create system message with context
        // $systemMessage = "You are a helpful assistant for our project. Use this documentation to answer questions: " . $this->documentation;

        try {
            /*  // Verify API key is set
             if (empty(config('openai.api_key'))) {
                 throw new \Exception('OpenAI API key is not configured');
             }

             $result = OpenAI::chat()->create([
                 'model' => 'o1-mini', // https://platform.openai.com/docs/models
                 'messages' => [
                     ['role' => 'system', 'content' => $systemMessage],
                     ['role' => 'user', 'content' => $userMessage],
                 ],
                 'temperature' => 0.7,
             ]);

             Log::info('OpenAI response received successfully');

             return response()->json([
                 'success' => true,
                 'message' => $result->choices[0]->message->content,
             ]);
  */

            // $result = Ollama::prompt('How do I create a route in Laravel 10?')
            //     ->model('llama3.2')
            //     ->options(['temperature' => 0.8])
            //     ->stream(false)
            //     ->ask();

            $output = '';

            $response = Ollama::model('Llama3.2')->show();

            // $response = Ollama::agent('You are a snarky friend with one-line responses')
            //     ->prompt("I didn't sleep much last night")
            //     ->model('llama3.2')
            //     ->options(['temperature' => 0.1])
            //     ->stream(true)
            //     ->ask();

            // $output = new BufferedConsoleOutput();
            // $responses = Ollama::processStream(
            //     $response->getBody(),
            //     function ($data) use ($output) {
            //         $output->write($data['response']);
            //     }
            // );

            // $output->write("\n");
            // $complete = implode('', array_column($responses, 'response'));
            // $output->write("<info>$complete</info>");

            Log::info('Ollama response received successfully');

            return response()->json([
                'success' => true,
                // 'message' => $result->choices[0]->message->content,
                'message' => $response,
            ]);

        } catch (\Exception $e) {
            // Log the detailed error
            Log::error('ChatGPT Error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Return more specific error message
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'debug_info' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
    }

    public function index()
    {
        return view('chat.index');
    }
}
