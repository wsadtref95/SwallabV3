<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rcomment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'post_id', 'rating', 'comment'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAvatarUrlAttribute()
    {
        return $this->user->avatar ? asset($this->user->avatar) : asset('images/default-avatar.jpg');
    }
}
