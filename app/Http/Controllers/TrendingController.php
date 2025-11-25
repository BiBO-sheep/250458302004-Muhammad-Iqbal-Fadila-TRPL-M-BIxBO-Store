<?php

namespace App\Http\Controllers;

use App\Models\Product;

class TrendingController extends Controller
{
    public function index()
    {
        $trending = Product::where('visibility', true)
            ->orderBy('is_trending', 'desc')
            ->orderBy('view_count', 'desc')
            ->take(10)
            ->get();

        return view('home.trending', compact('trending'));
    }
}
