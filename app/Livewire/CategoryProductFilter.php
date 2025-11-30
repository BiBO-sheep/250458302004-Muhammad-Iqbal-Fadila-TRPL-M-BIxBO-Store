<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Category;
use App\Models\Store;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryProductFilter extends Component
{
    use WithPagination;

    public $category;
    public $categoryId;

    // Filter properties
    public $selectedCategories = [];
    public $selectedStores = [];
    public $selectedStatus = [];
    public $minPrice = 0;
    public $maxPrice = 10000;
    public $priceRange = 10000;

    public function mount($category)
    {
        $this->category = $category;
        $this->categoryId = $category->id;

        // Set default selected category
        $this->selectedCategories = [$category->id];

        // Get max price from products
        $this->maxPrice = Product::max('discounted_price') ?? 10000;
        $this->priceRange = $this->maxPrice;
    }

    public function updatingSelectedCategories()
    {
        $this->resetPage();
    }

    public function updatingSelectedStores()
    {
        $this->resetPage();
    }

    public function updatingSelectedStatus()
    {
        $this->resetPage();
    }

    public function updatingPriceRange()
    {
        $this->resetPage();
    }

    public function applyFilters()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->selectedCategories = [$this->categoryId];
        $this->selectedStores = [];
        $this->selectedStatus = [];
        $this->priceRange = $this->maxPrice;
        $this->resetPage();
    }

    public function render()
    {
        // Get all categories for filter
        $categories = Category::all();

        // Get all stores for filter
        $stores = Store::all();

        // Query products with filters
        $products = Product::with(['images', 'category', 'store'])
            ->when(!empty($this->selectedCategories), function ($query) {
                $query->whereIn('category_id', $this->selectedCategories);
            })
            ->when(!empty($this->selectedStores), function ($query) {
                $query->whereIn('store_id', $this->selectedStores);
            })
            ->when(!empty($this->selectedStatus), function ($query) {
                if (in_array('in_stock', $this->selectedStatus)) {
                    $query->orWhere('stock_status', 'in_stock');
                }
                if (in_array('on_sale', $this->selectedStatus)) {
                    $query->orWhere(function ($q) {
                        $q->whereNotNull('discounted_price')
                            ->whereColumn('discounted_price', '<', 'regular_price');
                    });
                }
                if (in_array('discontinued', $this->selectedStatus)) {
                    $query->orWhere('stock_status', 'discontinued');
                }
            })
            ->when($this->priceRange, function ($query) {
                $query->where('discounted_price', '<=', $this->priceRange);
            })
            ->where('status', 'active')
            ->paginate(12);

        return view('home.categories', [
            'products' => $products,
            'categories' => $categories,
            'stores' => $stores,
        ]);
    }
}
