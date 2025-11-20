<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['id','name'];

    //1:n no tiene FK (referenciada desde post)
    public function posts(){
        return $this->hasMany(Post::class);
    }
}
