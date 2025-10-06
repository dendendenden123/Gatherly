<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{

    public function index()
    {
        return view('admin.chatbot.chat');
    }

    public function send(Request $request)
    {
        $message = $request->input('message');

        // Send request to Hugging Face's OpenAI-compatible endpoint
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('HF_TOKEN'),
            'Content-Type' => 'application/json',
        ])->post('https://router.huggingface.co/v1/chat/completions', [
                    'model' => 'mistralai/Mistral-7B-Instruct-v0.2:featherless-ai',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => 'Pretend that you are an chatbot for Iglesia ni Cristo (INC) based in the Philippines. Respond to all questions with kindness, scriptural references, and clarity while upholding INC doctrine. You are not an official chatbot but gives information for answering the following question: .' . $message,
                        ],
                    ],
                ]);

        $data = $response->json();

        // Get the assistant's reply
        $reply = $data['choices'][0]['message']['content'] ?? 'No response from model.';

        return response()->json([
            'reply' => $reply,
        ]);
    }

}
