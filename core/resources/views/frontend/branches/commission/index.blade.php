<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch Commission</title>

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

        .badge {
            font-size: 0.85rem;
            padding: 0.5em 0.75em;
            border-radius: 8px;
        }

        .badge-success {
            background-color: #10B981;
            color: white;
        }

        .badge-danger {
            background-color: #EF4444;
            color: white;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-sm {
            padding: 0.35rem 0.65rem;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
<div class="branch-dashboard">
    <!-- Header -->
    @include('frontend.branches.partials.header')

    <!-- Sidebar -->
    @include('frontend.branches.partials.sidebar')

    <main class="branch-main-content">

        <!-- Total Commission Box -->
        <div class="mb-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">Total Commission</h5>
                        <h2 class="fw-bold text-primary">₹ {{ number_format($totalCommission, 2) }}</h2>
                    </div>
                    <i class="fa-solid fa-coins fa-3x text-warning"></i>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">New Commision</h4>
            <form method="GET" action="{{ route('branch.commission') }}" class="d-flex gap-2">
                <select name="filter" class="form-select" onchange="this.form.submit()">
                    <option value="daily" {{ request('filter') == 'daily' ? 'selected' : '' }}>Daily Commission</option>
                    <option value="monthly" {{ request('filter') == 'monthly' ? 'selected' : '' }}>Monthly Commission</option>
                    <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>All</option>
                </select>
            </form>
        </div>

        <!-- Commission Table -->
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Order ID</th>
                    <th>Total BV</th>
                    <th>Commission %</th>
                    <th>Commission Amount</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @forelse($commissions as $index => $commission)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $commission->created_at->format('d M Y') }}</td>
                        <td>{{ $commission->order_id }}</td>
                        <td>{{ number_format($commission->total_bv, 2) }}</td>
                        <td>{{ $commission->commission_percent }}%</td>
                        <td class="fw-bold text-success">₹ {{ number_format($commission->commission_amount, 2) }}</td>
                        <td>
                            <span class="badge 
                                {{ $commission->status === 'paid' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ ucfirst($commission->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No commissions found</td>
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
