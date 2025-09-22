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
    public function definition(): array
{
    return [
        'user_id' => 1, // Kita anggap ada user dengan id=1
        'title' => fake()->sentence(5), // Membuat kalimat acak
        'body' => fake()->paragraphs(3, true), // Membuat 3 paragraf acak
        'category' => fake()->randomElement(['berita', 'artikel', 'pengumuman']),
    ];
}
}
