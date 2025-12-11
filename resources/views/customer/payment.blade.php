@extends('customer.layouts.layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Payment</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Payment</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Pending Orders</h3>
                                <div class="card-tools">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fas fa-sync-alt refresh-btn" title="Refresh"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                @php
                                    $pendingOrders = Auth::user()->orders()->where('status', 'pending')->get();
                                @endphp

                                @if ($pendingOrders->isEmpty())
                                    <div class="text-center py-5">
                                        <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                                        <h4 class="text-muted">No Pending Orders</h4>
                                        <p class="text-muted">You don't have any orders that need payment.</p>
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Date</th>
                                                    <th>Items</th>
                                                    <th>Total Amount</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pendingOrders as $order)
                                                    @php
                                                        $itemCount = $order->orderItems?->count() ?? 0;
                                                        $orderDate = $order->created_at->format('d M Y');
                                                    @endphp

                                                    <tr>
                                                        <td>
                                                            <div class="font-weight-bold">
                                                                #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
                                                            <small class="text-muted">Ref: ORD{{ $order->id }}</small>
                                                        </td>
                                                        <td>
                                                            <div>{{ $orderDate }}</div>
                                                            <small
                                                                class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span
                                                                    class="badge badge-light mr-2">{{ $itemCount }}</span>
                                                                <span>item{{ $itemCount > 1 ? 's' : '' }}</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="font-weight-bold text-success">
                                                                Rp {{ number_format($order->total, 0, ',', '.') }}
                                                            </div>
                                                            @if ($order->shipping_cost > 0)
                                                                <small class="text-muted">
                                                                    Includes shipping: Rp
                                                                    {{ number_format($order->shipping_cost, 0, ',', '.') }}
                                                                </small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-warning">
                                                                <i class="fas fa-clock mr-1"></i>
                                                                {{ ucfirst($order->status) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex justify-content-center">
                                                                <form method="POST"
                                                                    action="{{ route('customer.order.pay', $order->id) }}"
                                                                    class="mr-2">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn btn-success btn-sm btn-pay">
                                                                        <i class="fas fa-credit-card mr-1"></i>
                                                                        Pay Now
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h5 class="card-title"><i
                                                            class="fas fa-info-circle text-primary mr-2"></i>Payment
                                                        Information</h5>
                                                    <p class="card-text small">
                                                        • Payments will be processed securely<br>
                                                        • Complete payment within 24 hours<br>
                                                        • You'll receive payment confirmation via email
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <div class="d-inline-block text-left">
                                                <div class="mb-2">
                                                    <span class="text-muted">Total Pending:</span>
                                                    <h4 class="d-inline-block ml-2 text-danger">
                                                        Rp {{ number_format($pendingOrders->sum('total'), 0, ',', '.') }}
                                                    </h4>
                                                </div>
                                                <small class="text-muted">{{ $pendingOrders->count() }} order(s) pending
                                                    payment</small>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@push('styles')
    <style>
        .btn-pay {
            transition: all 0.3s ease;
        }

        .btn-pay:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
        }

        .refresh-btn {
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .refresh-btn:hover {
            transform: rotate(180deg);
            color: #007bff;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }

        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Refresh button functionality
            $('.refresh-btn').click(function() {
                location.reload();
            });

            // Confirm payment
            $('form').submit(function(e) {
                const btn = $(this).find('.btn-pay');
                btn.prop('disabled', true);
                btn.html('<i class="fas fa-spinner fa-spin mr-1"></i> Processing...');
            });

            // Add subtle animation to table rows
            $('tbody tr').each(function(i) {
                $(this).delay(i * 100).fadeIn(300);
            });
        });
    </script>
@endpush
