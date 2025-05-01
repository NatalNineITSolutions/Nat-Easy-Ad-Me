@extends('backend.admin-master')
@section('site-title')
    {{__('All Age Ranges')}}
@endsection

@section('content')
<div class="row align-items-center mt-20">
    <div class="col-md-6">
        <h5>Age Ranges</h5>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="{{ route('admin.matrimony.add-age') }}" class="btn btn-primary">Add Age</a>
    </div>

    <table class="table table-bordered mt-25">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Age Range</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ages as $index => $age)
                <tr id="age-row-{{ $age->id }}">
                    <td>{{ $ages->firstItem() + $index }}</td>
                    <td>{{ $age->from_age }} - {{ $age->to_age }}</td>
                    <td>
                        <a href="{{ route('admin.matrimony.edit-age', $age->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-danger btn-sm delete-age" data-id="{{ $age->id }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center">No age ranges found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-3">
        {{ $ages->links() }}
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".delete-age").forEach(button => {
            button.addEventListener("click", function () {
                let ageId = this.getAttribute("data-id");
                let url = "{{ route('admin.matrimony.delete-age', ':id') }}".replace(':id', ageId);

                if (confirm("Are you sure you want to delete this age range?")) {
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
                            document.getElementById("age-row-" + ageId).remove();
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
