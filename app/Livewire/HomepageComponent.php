<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class HomepageComponent extends Component
{
    public function render()
    {
        $latestProducts = Product::orderBy('created_at', 'desc')->limit(8)->get();
        return view('livewire.homepage-component', ['products' => Product::all(), 'latestProducts' => $latestProducts]);
    }
}
