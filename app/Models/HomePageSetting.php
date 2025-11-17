<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePageSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'discounted_product_id',
        'discount_percent',
        'discount_heading',
        'discount_subheading',
        'featured_product_1_id',
        'featured_product_2_id'
    ];

    public function discountProduct(){
        return $this->belongsTo(Product::class);
    }

    public function featuredProduct()
    {
        return $this->belongsTo(Product::class);
    }

    public function featuredProduct2()
    {
        return $this->belongsTo(Product::class);
    }

}
