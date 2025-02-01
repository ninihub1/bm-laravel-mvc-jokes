<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Joke extends Model
{
    use SoftDeletes;
    protected $fillable =
        [
            'title',
            'content',
            'category_id',
            'tags',
            'author_id',

        ];

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
