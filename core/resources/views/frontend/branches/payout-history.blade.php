<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch Payout History</title>

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

        .btn-download {
            background-color: #3B82F6;
            color: white;
            border-radius: 8px;
            padding: 0.35rem 0.75rem;
            font-size: 0.85rem;
            text-decoration: none;
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

        <!-- Payout History Table -->
        <div class="table-container">
            <h4 class="mb-4">Payout History</h4>

            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Commission Amount</th>
                        <th>Statement</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($histories as $index => $history)
                        <tr>
                            <td>{{ $histories->firstItem() + $index }}</td>
                            <td>{{ $history->created_at->format('d M Y') }}</td>
                            <td class="fw-bold text-success">₹ {{ number_format($history->total_commission, 2) }}</td>
                            <td>
                                <a href="{{ route('branch.payout.history.download', $history->id) }}" class="btn-download">
                                    Download
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No payout history found</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $histories->links() }}
            </div>

        </div>

    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<x-branch.js />
</body>
</html>