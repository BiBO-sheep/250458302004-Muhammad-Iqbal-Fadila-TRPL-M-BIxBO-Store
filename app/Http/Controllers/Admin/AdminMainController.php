<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminMainController extends Controller
{
    public function index()
    {
        return view('admin.admin');
    }

    public function setting()
    {
        $products = Product::all();
        return view('admin.settings', compact('products'));
    }

    public function manage_user()
    {
        return view('admin.manage.user');
    }

    public function manage_stores()
    {
        return view('admin.manage.store');
    }

    public function cart_history()
    {
        return view('admin.cart.history');
    }

    public function order_history()
    {
        return view('admin.order.history');
    }

    public function tes()
    {
        return view('admin.category.manage');
    }
}
