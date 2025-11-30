<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\HomePageSetting;

class HomePageController extends Controller
{
    public function index()
    {
        $homepagesetting = HomePageSetting::with([
            'discountedProduct',
            'featuredProduct1',
            'featuredProduct2',
        ])->first();

        // Ambil gambar untuk featured product 1
        $featuredProduct1Images = [];
        if ($homepagesetting->featuredProduct1) {
            $featuredProduct1Images = $homepagesetting->featuredProduct1->images()
                ->pluck('img_path')
                ->toArray();
        }

        // Ambil gambar untuk featured product 2
        $featuredProduct2Images = [];
        if ($homepagesetting->featuredProduct2) {
            $featuredProduct2Images = $homepagesetting->featuredProduct2->images()
                ->pluck('img_path')
                ->toArray();
        }

        return view('home.index', compact(
            'homepagesetting',
            'featuredProduct1Images',
            'featuredProduct2Images'
        ));
    }

    public function showCategoryProducts(Request $request, $category_name)
    {
        $category = Category::where('category_name', $category_name)->firstOrFail();

        // Get all categories for filter
        $categories = Category::all();

        // Get max price for price range
        $maxPrice = Product::max('discounted_price') ?? 10000;

        // Get products with filtering support
        $productsQuery = Product::with(['images', 'category'])
            ->whereHas('category', function ($query) use ($category_name) {
                $query->where('category_name', $category_name);
            });

        // Apply category filters if any
        if ($request->has('categories') && !empty($request->categories)) {
            $selectedCategories = is_array($request->categories)
                ? $request->categories
                : explode(',', $request->categories);

            $productsQuery->whereHas('category', function ($query) use ($selectedCategories) {
                $query->whereIn('id', $selectedCategories);
            });
        }

        // Apply price filter if any
        if ($request->has('min_price') && $request->has('max_price')) {
            $minPrice = $request->min_price;
            $maxPriceFilter = $request->max_price;
            $productsQuery->whereBetween('discounted_price', [$minPrice, $maxPriceFilter]);
        }

        // Apply status filters if any
        if ($request->has('statuses') && !empty($request->statuses)) {
            $selectedStatuses = is_array($request->statuses)
                ? $request->statuses
                : explode(',', $request->statuses);

            $productsQuery->where(function ($query) use ($selectedStatuses) {
                if (in_array('in-stock', $selectedStatuses)) {
                    $query->orWhere('stock_quantity', '>', 0); // Asumsikan kolom stock_quantity
                }
                if (in_array('on-sale', $selectedStatuses)) {
                    $query->orWhere('is_on_sale', true); // Asumsikan kolom is_on_sale
                }
                if (in_array('discontinued', $selectedStatuses)) {
                    $query->orWhere('is_discontinued', true); // Asumsikan kolom is_discontinued
                }
            });
        }

        // Check if it's an AJAX request for filtering
        if ($request->ajax()) {
            $products = $productsQuery->paginate(12); // Gunakan paginate untuk performa

            return response()->json([
                'success' => true,
                'html' => view('home.partials.products_grid', compact('products'))->render(),
                'count' => $products->count()
            ]);
        }

        $products = $productsQuery->paginate(12); // Gunakan paginate untuk halaman utama

        return view('home.categories', compact(
            'category',
            'products',
            'categories',
            'maxPrice'
        ));
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
