<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModelHasRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Example: Assign the 'Admin' role (ID: 1) to the user with ID 1
        DB::table('model_has_roles')->insert([
            [
                'role_id' => 1,           // Role ID
                'model_type' => 'App\Models\User', // Model type (typically User)
                'model_id' => 1,          // Model ID (e.g., User ID)
            ],
        ]);
    }
}
