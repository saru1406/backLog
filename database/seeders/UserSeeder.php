<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as FakerFactory;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'test',
            'email' => 'test@test',
            'password' => Hash::make('password')
        ]);

        $faker = FakerFactory::create('en_US');
        //　companyに紐づくuserを複数作成
        $companies = Company::all();
        foreach ($companies as $company) {
            for ($i = 0; $i < 5; $i++) {
                User::factory()->create([
                    'company_id' => $company->id,
                    'email' => $faker->unique()->userName() . '@' . $company->domain
                ]);
            }
        }
    }
}
