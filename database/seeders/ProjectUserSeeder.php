<?php

namespace Database\Seeders;

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
        $users = User::select('id')->get();
        $projects = Project::select('id')->get();

        $projects->map(
            fn ($project) => $project->users()->attach(
                $users->random(rand(1, 10))->pluck('id')->toArray()
            )
        );
    }
}
