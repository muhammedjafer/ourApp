<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Intervention\Image\Facades\Image;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //the name of the function is the name of the column in the database
    protected function avatar(): Attribute 
    {
        return Attribute::make(get: function ($value) {
                return $value ? '/storage/avatars/' . $value : '/fallback-avatar.jpg';
        });
    }

    public function feedPosts()
    {
        return $this->hasManyThrough(Post::class, Follow::class, 'user_id', 'user_id', 'id', 'followeduser');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    //This will return the user is being followed to who
    public function followers()
    {
        return $this->hasMany(Follow::class, 'followeduser');
    }

    // This will return whom the user that are following the user
    public function followingTheseUsers()
    {
        return $this->hasMany(Follow::class, 'user_id');
    }
}
