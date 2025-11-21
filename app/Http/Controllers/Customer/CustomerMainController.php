<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;


class CustomerMainController extends Controller
{
    public function index()
    {
        return view('customer.profile');
    }

    public function history()
    {
        return view('customer.history');
    }

    public function payment()
    {
        return view('customer.payment');
    }

    public function affiliate()
    {
        return view('customer.affiliate');
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Keranjang kosong!');
        }

        $total = collect($cart)->sum(function ($item) {
            return ($item['price'] ?? 0) * ($item['quantity'] ?? 0);
        });

        // Buat order baru
        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'status' => 'pending'
        ]);

        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        // Kosongkan keranjang
        session()->forget('cart');

        return redirect()->route('customer.order.show', $order->id)->with('success', 'Checkout berhasil!');
    }

    public function showOrder(Order $order)
    {
        $order->load('items.product');

        // Pastikan user hanya bisa lihat order sendiri
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('customer.order.show', compact('order'));
    }
}
