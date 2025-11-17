<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'sku' => $this->faker->unique()->word(),
            'seller_id' => $this->faker->randomElement([2,3,4]),
            'category_id' => 1, // Assuming a default category
            'subcategory_id' => $this->faker->randomElement([2,3]),
            'store_id' => 1, // Assuming a default store
            'regular_price' => $this->faker->randomFloat(2, 10, 100),
            'discounted_price' => $this->faker->optional(0.5)->randomFloat(2, 5, 50),
            'tax_rate' => $this->faker->randomFloat(2, 0, 20),
            'stock_quantity' => $this->faker->numberBetween(1, 100),
            'stock_status' => $this->faker->randomElement(['In Stock', 'Out of Stock']),
            'slug' => $this->faker->slug(),
            'visibility' => $this->faker->boolean(),
            'meta_title' => $this->faker->sentence(),
            'meta_description' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['Draft', 'Published']),
        ];
    }
}
