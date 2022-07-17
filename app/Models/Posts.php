<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Posts extends Model
{
    use HasFactory;
    protected $table = 'posts';


    function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
