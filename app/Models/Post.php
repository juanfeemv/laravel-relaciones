<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'body',
        'category_id',
        'author_profile_id',
    ];

    //1:1 - tiene FK a categoria
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function authorProfile()
    {
        return $this->belongsTo(Profile::class, 'author_profile_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps(); // post_tag
    }
}
