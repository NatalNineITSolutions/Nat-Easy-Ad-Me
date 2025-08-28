<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History - Branch Dashboard</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <x-branch.css />

    <style>
        body {
            background-color: #F1F5F9;
            font-family: 'Inter', sans-serif;
        }

        .branch-main-content {
            margin-left: 280px;
            padding: 2rem;
            margin-top: 10px;
        }

        .table-container {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .table thead {
            background: #f8fafc;
            font-weight: 600;
            color: #1e293b;
        }

        .table td, .table th {
            vertical-align: middle;
        }

        .badge-success {
            background-color: #10B981;
            color: white;
        }

        .badge-warning {
            background-color: #F59E0B;
            color: white;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
    </style>
</head>
<body>
<div class="branch-dashboard">
    <!-- Header -->
    @include('frontend.branches.partials.header')

    <!-- Sidebar -->
    @include('frontend.branches.partials.sidebar')

    <!-- Main Content -->
    <main class="branch-main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Order History</h1>
        </div>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Delivery</th>
                        <th>Grand Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->first_name }} {{ $order->last_name }} ({{ $order->email }})</td>
                            <td>{{ $order->product_name }}</td>
                            <td>{{ $order->product_quantity }}</td>
                            <td>{{ $order->product_total_price }}</td>
                            <td>{{ $order->total_delivery_charge }}</td>
                            <td>{{ $order->grand_total }}</td>
                            <td>
                                <form action="{{ route('branch.orders.update.status', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                                        @foreach(['pending','packaging','shipped','delivered'] as $status)
                                            <option value="{{ $status }}" {{ $order->order_status === $status ? 'selected' : '' }}>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>

                            <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y h:i A') }}</td>
                            <td>
                                <a href="{{ route('branch.products.invoice', $order->id) }}" 
                                class="btn btn-sm btn-primary">
                                    <i class="fas fa-file-pdf"></i> Download Invoice
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<x-branch.js />
</body>
</html>