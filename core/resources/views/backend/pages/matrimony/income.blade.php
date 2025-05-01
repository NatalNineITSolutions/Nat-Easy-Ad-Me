@extends('backend.admin-master')
@section('site-title')
    {{__('All Income Ranges')}}
@endsection

@section('content')
<div class="row align-items-center mt-20">
    <div class="col-md-6">
        <h5>Income Ranges</h5>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="{{ route('admin.matrimony.add-income') }}" class="btn btn-primary">Add Income</a>
    </div>

    <table class="table table-bordered mt-25">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Income Range</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($incomes as $index => $income)
                <tr id="income-row-{{ $income->id }}">
                    <td>{{ $incomes->firstItem() + $index }}</td>
                    <td>{{ $income->from_income }} - {{ $income->to_income }}</td>
                    <td>
                        <a href="{{ route('admin.matrimony.edit-income', $income->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-danger btn-sm delete-income" data-id="{{ $income->id }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center">No income ranges found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-3">
        {{ $incomes->links() }}
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".delete-income").forEach(button => {
            button.addEventListener("click", function () {
                let incomeId = this.getAttribute("data-id");
                let url = "{{ route('admin.matrimony.delete-income', ':id') }}".replace(':id', incomeId);

                if (confirm("Are you sure you want to delete this income range?")) {
                    fetch(url, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json"
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById("income-row-" + incomeId).remove();
                            alert(data.message);
                        } else {
                            alert("Something went wrong!");
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
