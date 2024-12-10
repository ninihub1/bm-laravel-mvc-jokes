<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
        'Puns',
        'Knock-Knock',
        'Transportation',
        'Dad',
        'Animal',
        'Blonde',
        'Lawyer',
        'Doctor',
        'Lightbulb',
        'Relationship',
        'Halloween',
        'Humor',
        'Food',
        'Workplace',
        'School',
        'Technology',
        'Geek/Nerd',
        'Political',
        'Holiday'
    ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
