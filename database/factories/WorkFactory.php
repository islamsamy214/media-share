<?php

namespace Database\Factories;

use App\Models\Work;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Work::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $work_title = $this->faker->unique()->catchPhrase;

        return [
            'title' => $work_title,
            'slug' => str_replace(' ', '-', $work_title),
            'description' => $this->faker->realText(200),
            'link' => $this->faker->url,
            'work_date' => $this->faker->date('Y-m-d', 'now'),
            'user_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
