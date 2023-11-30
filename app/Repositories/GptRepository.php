<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Log;
use OpenAI;

class GptRepository implements GptRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createChildTasks(string $taskTitle, string $taskContent): string
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
                    'content' => '親タスク:' . $taskTitle . ' 親タスク説明:' . $taskContent . '子タスクのタイトルと説明を箇条書きで生成してください。\n
                    Laravelを使用して実装するための子タスクを箇条書きで生成してください。各子タスクには、タスクのタイトルと具体的な実装手順を含めてください。\n
                    例）\n
                    - 子タスク1: お気に入り機能のUIを作成する\n
                        - お気に入りボタンを設置する\n
                        - ユーザーがお気に入りボタンを押すと、お気に入りが登録される\n
                    - 子タスク2: お気に入り情報をデータベースに保存する\n
                        - ユーザーごとにお気に入り情報を保存するデータベースを設計する\n
                        - お気に入り情報が更新された際にデータベースを更新する処理を実装する\n
                    - 子タスク3: お気に入り一覧画面を作成する\n
                        - ユーザーごとにお気に入り一覧を表示する画面を設計する\n
                        - お気に入り一覧から選択したアイテムにアクセスできるようにリンクを作成する\n
                    - 子タスク4: セキュリティ対策を行う\n
                        - お気に入り情報をデータベースに保存する際にデータの暗号化を行う\n
                        - ログイン状態を管理し、お気に入り情報にアクセスできるユーザーを制限する'
                ],
            ],
        ]);
        // dd($result->choices[0]->message->content);
        Log::info($result->choices[0]->message->content);
        return $result->choices[0]->message->content;
    }
}
