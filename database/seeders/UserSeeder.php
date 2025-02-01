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
                'id' => 1,
                'given_name' => 'Blony',
                'family_name' => 'Maunela',
                'nickname' => 'nini',
                'email' => 'blony@example.com',
                'password' => 'Password1',
                'email_verified_at' => null,
            ],
            [
                'id'  => 2,
                'given_name' => 'Wilka',
                'family_name' => 'Mangue',
                'nickname' => 'jennin',
                'email' => 'wilka@example.com',
                'password' => 'Password1',
                'email_verified_at' => null,
            ],
            [
                'id' => 3,
                'given_name' => 'Tamsyn',
                'family_name' => 'Hannan',
                'nickname' => 'TamsynH',
                'email' => 'tamsyn@example.com',
                'password' => 'Password2',
                'email_verified_at' => null,
            ],
            [
                'id' => 4,
                'given_name' => 'Aliha',
                'family_name' => 'Maiden',
                'nickname' => 'AlihaM',
                'email' => 'aliha@example.com',
                'password' => 'Password1',
                'email_verified_at' => null,
            ],
            [
                'id' => 5,
                'given_name' => 'Louren',
                'family_name' => 'Chichava',
                'nickname' => 'maedejuner',
                'email' => 'louren@example.com',
                'password' => 'Password1',
                'email_verified_at' => null,
            ],
        ];

        $numRecords = count($users);
        $this->command->getOutput()->progressStart($numRecords);

        foreach ($users as $newRecord) {
            User::create($newRecord);
            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();
    }
}
