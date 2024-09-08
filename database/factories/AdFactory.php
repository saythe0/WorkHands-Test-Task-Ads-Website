<?php

namespace Database\Factories;

use App\Models\Ad;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ad>
 */
class AdFactory extends Factory
{
    protected $model = Ad::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->text(700),
            'photo_links' => json_encode([
                fake()->imageUrl(),
                fake()->imageUrl(),
                fake()->imageUrl()
            ]),
            'price' => fake()->randomFloat(2, 10, 1000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
