<?php

namespace Database\Factories;

use App\Models\BlogCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BlogCategory::class;

    public function definition()
    {
        $cat_name = $this->faker->unique()->catchPhrase;

        return [
            'name' => $cat_name,
            'slug' => str_replace(' ', '-', $cat_name)
        ];
    }
}
