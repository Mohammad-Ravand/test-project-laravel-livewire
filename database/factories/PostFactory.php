<?php

namespace Database\Factories;

use App\Models\User;
use App\Enums\PostStatusEnum;
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
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'date' => $this->faker->dateTime,
            'user_id' => User::factory(),
            'description' => $this->faker->paragraph,
            'attachment' => $this->faker->filePath,
            'status' => $this->faker->randomElement(PostStatusEnum::cases()),
            'created_at' => $this->faker->dateTime,
            'updated_at' => $this->faker->dateTime,
        ];
    }
}
