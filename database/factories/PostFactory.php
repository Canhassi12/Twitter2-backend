<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'text' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio maiores exercitationem accusamus dolore sint nam blanditiis minima, eius voluptatibus harum repellat fugit nostrum officiis obcaecati nesciunt assumenda a odio dolores",
        ];
    }
}
