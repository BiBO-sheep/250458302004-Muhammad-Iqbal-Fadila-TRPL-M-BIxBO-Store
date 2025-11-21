<div>
  @forelse($cartItems as $productId => $item)
    @if(is_array($item) && isset($item['name'], $item['price'], $item['quantity']))
      <!-- cart item -->
      <div class="flex align-items-center justify-content-between flex-wrap gap-3 mb-5">
        <!-- item -->
        <div class="cart-item flex align-items-center flex-wrap gap-3">

          <p>{{ $item['name'] }}</p>

          <!-- item count -->
          <div class="item-count-wrap">
            <input class="cart-item-count" type="number" value="{{ $item['quantity'] }}" readonly>

            <a href="#!" wire:click="increaseQuantity({{ $productId }})" class="item-plus">
              <i class="fas fa-plus"></i>
            </a>

            <a href="#!" wire:click="decreaseQuantity({{ $productId }})" class="item-minus">
              <i class="fas fa-minus"></i>
            </a>
          </div>

          <p>${{ number_format($item['price'], 2) }} = <strong>${{ number_format($item['price'] * $item['quantity'], 2) }}</strong></p>

        </div>

        <!-- delete button -->
        <div>
          <a wire:click="removeItem({{ $productId }})" class="item-delete-btn" href="#!">
            <i class="fas fa-trash-alt"></i>
          </a>
        </div>
      </div>
    @else
      <!-- Invalid item structure - option to remove -->
      <div class="alert alert-warning">
        Invalid cart item detected.
        <button wire:click="removeItem({{ $productId }})" class="btn btn-sm btn-danger">Remove</button>
      </div>
    @endif
  @empty
    <p>Your cart is empty</p>
  @endforelse

  <!-- total -->
  <div class="flex align-items-center justify-content-between gap-4 fw-semibold border-top border-2 border-dark pt-2 mb-3">
    <p>Total</p>
    <p>${{ number_format($total, 2) }}</p>
  </div>

  <!-- tombol Checkout -->
  @if(!empty($cartItems))
    <form method="POST" action="{{ route('customer.checkout') }}">
      @csrf
      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        Checkout
      </button>
    </form>
  @endif
</div>

<script>
  document.addEventListener('livewire:load', function () {
    Livewire.on('notify', data => {
      const { title, type } = data;

      Swal.fire({
        toast: true,
        position: 'top-end',
        icon: type, // success, error, warning
        title: title,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      });
    });
  });
</script>

