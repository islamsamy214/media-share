<?php

namespace Database\Factories;

use App\Models\WorkCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WorkCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $cat_name = $this->faker->unique()->catchPhrase;

        return [
            'name' => $cat_name,
            'slug' => str_replace(' ', '-', $cat_name)
        ];
    }
}
