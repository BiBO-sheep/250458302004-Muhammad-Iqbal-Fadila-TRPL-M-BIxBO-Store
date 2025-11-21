<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class CartComponent extends Component
{
    protected $listeners = ['cartUpdated' => '$refresh'];

    /**
     * Mendapatkan data keranjang dari session.
     */
    public function getCartProperty(): array
    {
        return session()->get('cart', []);
    }

    /**
     * MENAMBAH kuantitas produk di keranjang.
     */
    public function increaseQuantity($productId): void
    {
        $cart = $this->cart;

        if (isset($cart[$productId])) {
            // Tambah quantity
            $cart[$productId]['quantity'] += 1;

            session()->put('cart', $cart);
            $this->dispatch('notify', title: 'Quantity Increased', type: 'success');
            $this->dispatch('cartUpdated');
        }
    }

    /**
     * MENGURANGI kuantitas produk di keranjang.
     */
    public function decreaseQuantity($productId): void
    {
        $cart = $this->cart;

        if (isset($cart[$productId])) {
            // Jika quantity lebih dari 1, kurangi
            if ($cart[$productId]['quantity'] > 1) {
                $cart[$productId]['quantity'] -= 1;

                session()->put('cart', $cart);
                $this->dispatch('notify', title: 'Quantity Decreased', type: 'success');
                $this->dispatch('cartUpdated');
            } else {
                // Jika quantity = 1, hapus item
                $this->removeItem($productId);
            }
        }
    }

    /**
     * Menghapus item dari keranjang.
     */
    public function removeItem($productId): void
    {
        $cart = $this->cart;

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
            $this->dispatch('notify', title: 'Item Removed', type: 'warning');
            $this->dispatch('cartUpdated');
        }
    }

    /**
     * Menghitung total harga.
     */
    public function getTotalProperty(): float
    {
        return collect($this->cart)
            ->filter(fn($item) => is_array($item)) // Filter hanya yang array
            ->sum(function ($item) {
                // Pastikan key 'price' dan 'quantity' ada
                $price = $item['price'] ?? 0;
                $quantity = $item['quantity'] ?? 0;
                return $price * $quantity;
            });
    }

    public function checkout()
    {
        if (empty($this->cart)) {
            $this->dispatch('notify', title: 'Keranjang kosong', type: 'error');
            return;
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $this->total,
            'status' => 'pending'
        ]);

        foreach ($this->cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        session()->forget('cart');
        $this->dispatch('cartUpdated');

        $this->dispatch('notify', title: 'Checkout berhasil!', type: 'success');

        return redirect()->route('customer.order.show', $order->id);
    }

    public function render()
    {
        return view('livewire.cart-component', [
            'cartItems' => $this->cart,
            'total' => $this->total,
        ]);
    }
}
