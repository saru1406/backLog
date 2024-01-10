<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 全てのプロジェクトを取得
        $projects = Project::all();

        // 各プロジェクトに対して処理
        $projects->each(function ($project) {
            // プロジェクトが属する企業を取得
            $company = Company::find($project->company_id);

            // その企業に属するユーザーを取得
            $companyUsers = $company->users;

            // ユーザーがいない場合はスキップ
            if ($companyUsers->isEmpty()) {
                return;
            }

            // プロジェクトにランダムな数のユーザーを紐付け
            $project->users()->attach(
                $companyUsers->random(rand(1, 5))->pluck('id')->toArray()
            );
        });
    }
}
