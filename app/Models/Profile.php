<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['bio'];

    //1:1 - tiene FK
    /*public function  usuario(){
        return $this->belongsTo(Usuario::class);
    }*/

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function postsAuthored()
    {
        return $this->hasMany(Post::class, 'author_profile_id');
    }

}
