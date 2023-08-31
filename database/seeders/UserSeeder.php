<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserSkill;
use App\Models\UserLanguage;
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
            ->count(10)
            ->create();
    }
}
