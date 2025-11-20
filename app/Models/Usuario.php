<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $fillable = ['nombre', 'email'];

    // 1:1 - no tiene FK
    public function profile(){
        return $this->hasOne(Profile::class);
    }
}
