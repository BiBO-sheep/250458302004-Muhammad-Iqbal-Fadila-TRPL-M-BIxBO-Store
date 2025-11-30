<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image',
        'seller_level',
        'is_verified',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',
            'seller_level' => 'integer',
        ];
    }

    // Existing relationships
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(ReviewsTable::class);
    }

    // New relationship for stores
    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    // Get all products from user's stores
    public function products()
    {
        return $this->hasManyThrough(Product::class, Store::class);
    }

    // Calculate average rating from reviews on user's products
    public function getAverageRatingAttribute()
    {
        $productIds = $this->products()->pluck('id');

        return ReviewsTable::whereIn('product_id', $productIds)
            ->avg('rating') ?? 0;
    }

    // Get total review count
    public function getTotalReviewsAttribute()
    {
        $productIds = $this->products()->pluck('id');

        return ReviewsTable::whereIn('product_id', $productIds)->count();
    }

    // Check if user can review a product
    public function canReviewProduct($productId)
    {
        $hasCompletedOrder = $this->orders()
            ->where('status', 'completed')
            ->whereHas('orderItems', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->exists();

        $hasNotReviewed = !$this->reviews()
            ->where('product_id', $productId)
            ->exists();

        return $hasCompletedOrder && $hasNotReviewed;
    }
}
