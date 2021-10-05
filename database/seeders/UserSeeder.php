<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use App\Models\Work;
use App\Models\UserSkill;
use App\Models\WorkSkill;
use App\Models\UserLanguage;
use App\Models\WorkCategory;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'super admin',
            'slug' => 'super_admin',
            'title' => 'adminstrator',
            'email' => 'super_admin@app.com',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
        ])->attachRole('super_admin');

        User::factory()
            ->has(UserSkill::factory()->count(2), 'skills')
            ->has(UserLanguage::factory()->count(2), 'languages')
            ->has(Work::factory()
                ->has(WorkSkill::factory()->count(2), 'skills')
                ->has(WorkCategory::factory()->count(2), 'categories')
                ->count(2), 'works')
            ->has(Blog::factory()
                ->has(BlogCategory::factory()->count(2), 'categories')
                ->count(2), 'blogs')
            ->count(10)
            ->create();
    }
}
