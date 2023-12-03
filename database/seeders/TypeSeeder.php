<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();
        $types = ['バグ', '実装', '改善'];
        foreach ($projects as $project) {
            foreach ($types as $type) {
                Type::create([
                    'project_id' => $project->id,
                    'name' => $type,
                ]);
            }
        }
    }
}
