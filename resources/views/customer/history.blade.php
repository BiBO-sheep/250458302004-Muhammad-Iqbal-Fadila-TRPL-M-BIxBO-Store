@extends('customer.layouts.layout')

@section('content')
<h3 class="mb-4">Order History</h3>

@if($orders->isEmpty())
    <div class="alert alert-info">
        Belum ada riwayat order ✅
    </div>
@else
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#Order ID</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                            <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-success">Paid</span>
                            </td>
                            <td>
                                <a href="{{ route('customer.order.show', $order->id) }}"
                                   class="btn btn-sm btn-primary">
                                   Lihat
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection
