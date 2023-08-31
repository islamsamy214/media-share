<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkCategory;
use App\Models\Work;

class WorkCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WorkCategory::factory()
            ->has(Work::factory()->count(3), 'works')
            ->count(5)
            ->create();
    }
}
