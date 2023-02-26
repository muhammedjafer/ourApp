<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    // it's returning your followers
    public function userDoingTheFollowing()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // whom you are following
    public function userBeingFollowed()
    {
        return $this->belongsTo(User::class, 'followeduser');
    }
}
