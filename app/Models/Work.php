<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'image', 'description', 'link', 'work_date', 'user_id'
    ];

    protected $appends = ["image_path"];

    public function getImagePathAttribute()
    {
        return asset('images/works/' . $this->image);
    } //end of getImagePathAttribute

    public function user()
    {
        return $this->belongsTo(User::class);
    } //end of user

    public function categories()
    {
        return $this->belongsToMany(WorkCategory::class, 'work_category');
    } //end of categories

    public function skills()
    {
        return $this->hasMany(WorkSkill::class);
    } //end of skills
}
