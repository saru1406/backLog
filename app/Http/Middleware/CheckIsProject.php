<?php

namespace App\Http\Middleware;

use App\Models\Project;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckIsProject
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        // リクエストからプロジェクトIDを取得（ルートパラメーターの名前に応じて変更が必要です）
        $projectId = $request->route('project');

        // プロジェクトを取得
        $project = Project::find($projectId);

        // プロジェクトが存在し、ユーザーの企業IDとプロジェクトの企業IDが一致する場合のみ、リクエストを続行
        if ($project && $user->company_id === $project->company_id) {
            return $next($request);
        }

        // アクセス権がない場合はエラーを返す
        return back()->with(['error_message' => '参加していないプロジェクトへ遷移できません。']);
    }
}
