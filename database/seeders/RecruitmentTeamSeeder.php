<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RecruitmentTeamSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'recruitmentsdi'],
            [
                'name' => 'Recruitment Team',
                'password' => Hash::make('adminrecruitmentsdi'),
                'role' => 'recruitmentteam',
            ]
        );

        $this->command->info('Recruitment Team user created/updated successfully.');
    }
}
