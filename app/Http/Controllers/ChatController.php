<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->documentation = "Your project documentation content here...";
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
        $systemMessage = "You are a helpful assistant for our project. Use this documentation to answer questions: " . $this->documentation;

        try {
            // Verify API key is set
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
