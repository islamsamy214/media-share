<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Seeder;
use App\Models\Blog;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BlogCategory::factory()
            ->has(Blog::factory()->count(3), 'blogs')
            ->count(5)
            ->create();
    }
}
