@extends('backend.admin-master')
@section('site-title')
    {{__('Branches Commission')}}
@endsection

@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/bootstrap-tagsinput.css')}}">
    <x-summernote.css />
    <x-media.css />
    <style>
        .debug-panel {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 4px solid #dc3545;
        }
        .debug-title {
            color: #dc3545;
            font-weight: 600;
            margin-bottom: 15px;
        }
        .debug-content {
            background: white;
            padding: 15px;
            border-radius: 5px;
            font-family: monospace;
            font-size: 14px;
            max-height: 200px;
            overflow-y: auto;
        }
        .modal-content {
            border-radius: 10px;
            border: none;
        }
        .modal-header {
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            border-radius: 10px 10px 0 0;
            padding: 15px 20px;
        }
        .modal-title {
            font-weight: 600;
            color: #2c3e50;
        }
        .modal-body {
            padding: 20px;
        }
        .modal-footer {
            border-top: 1px solid #e9ecef;
            border-radius: 0 0 10px 10px;
            padding: 15px 20px;
        }
        .btn-close:focus {
            box-shadow: none;
        }
        .form__input__single {
            margin-bottom: 15px;
        }
        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.15);
            border-color: #4299e1;
        }
        .alert-debug {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        .action-buttons form {
            display: inline;
        }
    </style>
@endsection

@section('content')
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
            <h4 class="mb-0">Commission History</h4>
            <form method="GET" action="{{ route('branch.commission.details', ['id' => $branchId]) }}" class="d-flex gap-2">
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
@endsection

@section('script')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-form').forEach(form => {
      form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to delete this product?')) {
          form.submit();
        }
      });
    });
  });
</script>
@endsection
