<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLanguage extends Model
{
    use HasFactory;

    protected $fillable = [
        'language', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    } //end of user relation
}
