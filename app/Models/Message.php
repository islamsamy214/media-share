<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_name', 'email', 'subject', 'slug', 'content', 'read'
    ];

    public function replies()
    {
        return $this->belongsToMany(User::class, 'replies')->withPivot('content')->withTimestamps();
    } //end of replies
}
