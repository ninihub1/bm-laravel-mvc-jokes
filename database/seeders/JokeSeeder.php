<?php

namespace Database\Seeders;

use App\Models\Joke;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class JokeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jokes = [
            [
                'id' => 1,
                'title' => 'Why did the scarecrow win an award?',
                'content' => 'Why did the scarecrow win an award? Because he was outstanding in his field!',
                'category_id' => Category::find(1)->id,
                'tags' => 'funny, farming',
                'author_id' => User::find(1)->id,
            ],
            [
                'id' => 2,
                'title' => "Why don't skeletons fight each other?",
                'content' => "Why don't skeletons fight each other? They don't have the guts.",
                'category_id' => Category::find(1)->id,
                'tags' => 'funny, skeleton',
                'author_id' => User::find(1)->id,
            ],
            [
                'id' => 3,
                'title' => 'I told my wife she was drawing her eyebrows too high.',
                'content' => 'I told my wife she was drawing her eyebrows too high. She looked surprised.',
                'category_id' => Category::find(2)->id,
                'tags' => 'funny, marriage',
                'author_id' => User::find(1)->id,
            ],
            [
                'id' => 4,
                'title' => 'Why did the computer go to the doctor?',
                'content' => 'Why did the computer go to the doctor? It had a virus.',
                'category_id' => Category::find(2)->id,
                'tags' => 'funny, technology',
                'author_id' => User::find(1)->id,
            ],
        ];

        $numRecords = count($jokes);
        $this->command->getOutput()->progressStart($numRecords);

        foreach ($jokes as $newRecord) {
            Joke::create($newRecord);
            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();
    }
}

