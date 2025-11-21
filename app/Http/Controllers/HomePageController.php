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

    public function create()
    {
        // Ambil baris pertama jika sudah ada, jika belum nanti user isi baru
        $setting = HomePageSetting::first();

        $products = Product::all();

        return view('admin.discount.create', compact('setting', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'discounted_product_id' => 'required|exists:products,id',
            'discount_percent' => 'required|numeric|min:1|max:100',
            'discount_heading' => 'nullable|string',
            'discount_subheading' => 'nullable|string',
            'featured_product_1_id' => 'nullable|exists:products,id',
            'featured_product_2_id' => 'nullable|exists:products,id',
        ]);

        // jika sudah ada, update. kalau belum, create baru
        HomePageSetting::updateOrCreate(
            ['id' => 1], // diasumsikan homepagesetting hanya 1 row
            $validated
        );

        return redirect()->back()->with('success', 'Homepage Setting updated!');
    }
}
