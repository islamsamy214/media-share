<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'image', 'content', 'youtube_link', 'user_id'
    ];

    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        return asset('images/blogs/' . $this->image);
    } //end of getImagePathAttribute

    public function categories()
    {
        return $this->belongsToMany(BlogCategory::class, 'blog_category');
    } //end of categories relation

    public function user()
    {
        return $this->belongsTo(User::class);
    } //end of user
}
