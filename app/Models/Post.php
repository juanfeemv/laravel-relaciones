<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'body'];

    //1:1 - tiene FK a categoria
    public function  category(){
        return $this->belongsTo(Category::class);
    }

    //n:m
    public function  tags(){
        return $this->belongsToMany(Tag::class)
        ->withPivot(['tag_id']);
    }

    public function authorProfile()
    {
        return $this->belongsTo(Profile::class, 'author_profile_id');
    }
}
