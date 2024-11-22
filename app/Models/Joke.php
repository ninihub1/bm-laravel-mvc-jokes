<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Joke extends Model
{
    protected $fillable =
        [
            'title',
            'content',
            'category',
            'tags',
            'author_id',

        ];

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
