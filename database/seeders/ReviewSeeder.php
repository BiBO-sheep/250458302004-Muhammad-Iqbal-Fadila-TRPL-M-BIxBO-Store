<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReviewsTable;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $products = Product::all();

        foreach ($products as $product) {
            // Create 3-5 random reviews per product
            $reviewCount = rand(3, 5);

            for ($i = 0; $i < $reviewCount; $i++) {
                $user = $users->random();

                // Check if user already reviewed this product
                if (ReviewsTable::where('user_id', $user->id)
                    ->where('product_id', $product->id)
                    ->exists()
                ) {
                    continue;
                }

                // Create fake order
                $order = Order::firstOrCreate([
                    'user_id' => $user->id,
                    'status' => 'completed',
                    'total_amount' => $product->price
                ]);

                // Create review
                $review = ReviewsTable::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'order_id' => $order->id,
                    'rating' => rand(3, 5),
                    'comment' => $this->getRandomComment(),
                    'status' => 'approved',
                    'created_at' => now()->subDays(rand(1, 30))
                ]);

                // 50% chance seller replied
                if (rand(0, 1)) {
                    $review->update([
                        'seller_reply' => $this->getRandomSellerReply(),
                        'replied_at' => now()->subDays(rand(0, 10))
                    ]);
                }
            }
        }
    }

    private function getRandomComment()
    {
        $comments = [
            'Great product! Exactly as described. Fast shipping too!',
            'Good quality for the price. Would recommend to others.',
            'Nice product but shipping took a bit long. Overall satisfied.',
            'Excellent! Better than expected. Will buy again.',
            'Product is okay, met my expectations.',
            'Very happy with this purchase. Good value for money.',
            'Quality product, fast delivery, great seller!',
            'Satisfied with the product. Does what it says.',
            'Good product but could be better packaged.',
            'Love it! Exactly what I needed.'
        ];

        return $comments[array_rand($comments)];
    }

    private function getRandomSellerReply()
    {
        $replies = [
            'Thank you for your review! We appreciate your business.',
            'We\'re glad you liked it! Thanks for shopping with us.',
            'Thank you for the feedback. We hope to see you again!',
            'Thanks for your purchase! We appreciate your support.',
            'We\'re happy you\'re satisfied! Thank you for your review.',
            'Thank you! Your satisfaction is our priority.',
            'We appreciate your business. Thanks for the great review!',
            'Thank you for choosing us! Hope to serve you again soon.'
        ];

        return $replies[array_rand($replies)];
    }
}
