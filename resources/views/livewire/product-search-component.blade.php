<div>

            <form wire:submit.prevent="search" action="" method="">
              <div class="search-bar">
                <input type="text" wire:model.debounce.500ms="query" name="query" placeholder="Search Product..." required>
                <div class="search-icon">
                  <i class="fas fa-search"></i>
                </div>
              </div>
            </form>

            <div class="search-result mt-4">
                @foreach ($result as $product)
                <a href="">{{ $product->product_name }}</a>
                @endforeach
            </div>
</div>
