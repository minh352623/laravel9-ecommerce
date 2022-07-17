<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Groups extends Model
{
    use HasFactory;

    protected $table = "groups";

    //lấy tất cả người dùng trong nhóm
    public function users()
    {
        return $this->hasMany(User::class, 'group_id', 'id');
    }


    //lấy ra người dùng đã tạo nhóm
    public function postBy()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
