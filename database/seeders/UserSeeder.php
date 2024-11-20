<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'id'=>1,
                'given_name'=>'Ad',
                'family_name'=>'Ministrator',
                'nickname'=>'ADM',
                'email'=>'admin@example.com',
                'password'=>'Password1',
                'email_verified_at'=>now(),
            ],
        ];

        $numRecords = count($users);
        $this->command->getOutput()->progressStart($numRecords);

        foreach ($users as $newRecord){
            User::create($newRecord);
            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();
    }
}
