<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable implements MustVerifyEmail
{
    use LaratrustUserTrait, HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'slug','email', 'email_verified_at', 'password', 'title', 'image', 'cv', 'about', 'education', 'country', 'city', 'facebook_id', 'linkedin_id', 'twitter_id', 'github_id', 'behance_id', 'youtube_id', 'instagram_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['image_path','cv_path'];

    public function getImagePathAttribute()
    {
        return asset('images/users/' . $this->image);
    } //end of returning image path

    public function getCvPathAttribute()
    {
        return asset('files/cvs/' . $this->cv);
    } //end of returning cv path

    public function languages()
    {
        return $this->hasMany(UserLanguage::class);
    } //end of languages

    public function skills()
    {
        return $this->hasMany(UserSkill::class);
    } //end of skills

    public function works()
    {
        return $this->hasMany(Work::class);
    } //end of works

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    } //end of blogs

    public function replies(){
        return $this->belongsToMany(Message::class,'replies')->withPivot('content');
    } //end of replies
}
