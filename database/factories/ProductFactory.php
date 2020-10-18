<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'image_url' => $this->faker->imageUrl(),
            'external_id' => $this->faker->numberBetween(),
        ];
    }
}
