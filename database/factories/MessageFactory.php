<?php

namespace Database\Factories;

use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Message::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $subject = $this->faker->sentence(6);
        $slug = substr(str_replace(' ', '-', $subject), 0, 50);

        return [
            'sender_name' => $this->faker->firstName(),
            'email' => $this->faker->safeEmail,
            'subject' => $subject,
            'slug' => $slug,
            'content' => $this->faker->realText(250),
            'read' => $this->faker->boolean,
        ];
    }
}
