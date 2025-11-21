@extends('customer.layouts.layout')

@section('customer_page_title')
Customer - Payment
@endsection

@section('customer_layout')
<div class="container-fluid">
    <h3 class="mb-4">Customer Payment Page</h3>

    @php
        // Ambil semua order pending user saat ini
        $pendingOrders = Auth::user()->orders()->where('status','pending')->get();
    @endphp

    @if($pendingOrders->isEmpty())
        <div class="alert alert-info">
            Tidak ada order yang perlu dibayar.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingOrders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>Rp {{ number_format($order->total,0,',','.') }}</td>
                            <td>{{ ucfirst($order->status) }}</td>
                            <td>
                                <!-- Tombol Bayar Sekarang -->
                                <form method="POST" action="{{ route('customer.checkout', $order->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">
                                        Bayar Sekarang
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
