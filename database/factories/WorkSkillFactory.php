<?php

namespace Database\Factories;

use App\Models\WorkSkill;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkSkillFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WorkSkill::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'skill' => $this->faker->jobTitle,
        ];
    }
}
