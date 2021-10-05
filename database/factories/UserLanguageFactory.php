<?php

namespace Database\Factories;

use App\Models\UserLanguage;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserLanguageFactory extends Factory
{

    protected $model = UserLanguage::class;

    public function definition()
    {
        return [
            'language' => $this->faker->languageCode,
        ];
    }
}
