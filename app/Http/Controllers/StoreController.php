<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan ini untuk Auth
use App\Models\Store; // Jika perlu query manual
use App\Models\Product; // Jika perlu

class StoreController extends Controller
{
    public function index()
    {
        // Ambil user yang login
        $user = Auth::user();

        // Ambil stores milik user
        $stores = $user->stores; // Asumsi relasi hasMany di User

        // Hitung total produk (dari semua stores user)
        $totalProducts = $user->products()->count(); // Atau $stores->sum('product_count') jika ada field

        // Hitung total stores
        $totalStores = $stores->count();

        // Hitung rating rata-rata (asumsi ada relasi reviews di Store atau Product)
        // Contoh: Jika Store punya reviews dengan field 'rating'
        $averageRating = $stores->avg(function ($store) {
            return $store->reviews()->avg('rating'); // Asumsi relasi hasMany reviews di Store
        }) ?? 0; // Default 0 jika tidak ada

        // Total reviews (untuk "(5012)")
        $totalReviews = $stores->sum(function ($store) {
            return $store->reviews()->count();
        });

        // Kirim data ke view
        return view('store.index', compact('user', 'stores', 'totalProducts', 'totalStores', 'averageRating', 'totalReviews'));
    }
}
