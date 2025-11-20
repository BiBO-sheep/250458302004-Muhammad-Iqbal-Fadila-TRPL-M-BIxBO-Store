<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductSearchComponent extends Component
{
    public string $query = '';

    public $result = [];

    public function search() {
        $this->result = Product::where('product_name', 'like', '%'. $this->query . '%')->limit(10)->get();
    }
    public function render()
    {
        return view('livewire.product-search-component');
    }
}
