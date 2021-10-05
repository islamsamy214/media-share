<?php

namespace Database\Factories;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    protected $model = Blog::class;

    public function definition()
    {
        $blog_title = $this->faker->unique()->catchPhrase;

        return [
            'title' => $blog_title,
            'slug' => str_replace(' ','-', $blog_title),
            'content' => $this->faker->realText(750),
            'youtube_link' => 'https://www.youtube.com/watch?v=rfxnmIPCzIc',
        ];
    }
}
