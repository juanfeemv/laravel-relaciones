<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['bio'];

    //1:1 - tiene FK
    public function  usuario(){
        return $this->belongsTo(Usuario::class);
    }

}
