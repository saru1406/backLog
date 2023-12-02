<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Log;
use OpenAI;

class GptRepository implements GptRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createChildTasks(string $message): string
    {
        // $client = OpenAI::factory()
        //     ->withApiKey($apiKey)
        //     ->withHttpHeader('X-My-Header', 'foo')
        //     ->make();
        $apiKey = config('api.open_ai_key');
        $client = OpenAI::client($apiKey);

        $result = $client->chat()->create([
            'model' => 'gpt-3.5-turbo-1106',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $message,
                ],
            ],
        ]);
        // dd($result->choices[0]->message->content);
        Log::info($result->choices[0]->message->content);
        return $result->choices[0]->message->content;
    }
}
