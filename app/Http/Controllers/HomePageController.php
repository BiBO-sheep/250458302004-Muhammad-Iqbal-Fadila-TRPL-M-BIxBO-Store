<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\HomePageSetting;

class HomePageController extends Controller
{
    public function index() {
        $homepagesetting = HomePageSetting::with([
                'discountedProduct.images',
                'featuredProduct1.images',
                'featuredProduct2.images',
        ])->first();


        return view('home.index', compact('homepagesetting'));
    }

    public function showCategoryProducts($category_name) {
        $category = Category::where('category_name', $category_name)->firstOrFail();

        $products = Product::where('category_id', $category->id)->get();

        return view('home.categories', compact('category', 'products'));
    }
}
