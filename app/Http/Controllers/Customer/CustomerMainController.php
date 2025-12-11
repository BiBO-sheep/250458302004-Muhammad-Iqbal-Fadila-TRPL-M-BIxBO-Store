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
        $orders = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->where('status', 'paid')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.history', compact('orders'));
    }


    public function payment()
    {
        return view('customer.payment');
    }

    public function payOrder(Request $request, Order $order)
    {
        // Pastikan order milik user yang login
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Pastikan hanya order pending yang bisa dibayar
        if ($order->status !== 'pending') {
            return back()->with('error', 'Order ini tidak bisa dibayar.');
        }

        // Update status order
        $order->update([
            'status' => 'paid'
        ]);

        return redirect()
            ->route('customer.payment')
            ->with('success', 'Pembayaran berhasil ✅');
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

        return redirect()->route('customer.payment', $order->id)->with('success', 'Checkout berhasil!');
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
