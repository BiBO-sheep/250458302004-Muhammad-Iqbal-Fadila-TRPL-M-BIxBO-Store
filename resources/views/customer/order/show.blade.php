@extends('customer.layouts.layout')
@section('customer_page_title')
Show - Order
@endsection
@section('customer_layout')
    <h1>Order #{{ $order->id }}</h1>
<p>Status: {{ $order->status }}</p>
<p>Total: Rp {{ number_format($order->total,0,',','.') }}</p>

<table>
    <thead>
        <tr>
            <th>Produk</th>
            <th>Qty</th>
            <th>Harga</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->items as $item)
        <tr>
            <td>{{ $item->product->name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>Rp {{ number_format($item->price,0,',','.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
