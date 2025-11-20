<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class GlobalCartManager extends Component
{
    protected $listeners = ['addToCartFromAnywhere' => 'addToCart'];
    public function addToCart($productId, $quantity=1) {
        $product = Product::findOrFail($productId);
        $cart = session()->get('cart',[]);

        if(isset($cart[$productId])){
            $cart[$productId] = $quantity;
        }else{
            $cart[$productId] = [
                'name' => $product->product_name,
                'price' => $product->regular_price,
                'quantity' => $quantity
            ];
        }

        session()->put('cart',$cart);

        $this->dispatch('cartUpdated');
        $this->dispatch('notify', title:'Added To Cart', type:'success');
    }

    public function render()
    {
        return view('livewire.global-cart-manager');
    }
}
