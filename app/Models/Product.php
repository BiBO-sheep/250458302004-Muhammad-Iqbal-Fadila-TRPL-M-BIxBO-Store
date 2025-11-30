<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'description',
        'sku',
        'seller_id',
        'category_id',
        'subcategory_id',
        'store_id',
        'regular_price',
        'discounted_price',
        'tax_rate',
        'stock_quantity',
        'stock_status',
        'slug',
        'visibility',
        'meta_title',
        'meta_description',
        'status'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    // Tambahkan di App/Models/Product.php

    public function reviews()
    {
        return $this->hasMany(ReviewsTable::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(ReviewsTable::class)->where('status', 'approved');
    }

    // Method untuk average rating
    public function averageRating()
    {
        return $this->approvedReviews()->avg('rating') ?? 0;
    }

    // Method untuk total reviews
    public function totalReviews()
    {
        return $this->approvedReviews()->count();
    }
}
