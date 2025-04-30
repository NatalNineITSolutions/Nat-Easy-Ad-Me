@extends('backend.admin-master')
@section('site-title')
    {{__('All Stars')}}
@endsection

<style>
    .icons {
        display: flex;
        align-items: center;
        gap: 15px;
    }
</style>

@section('content')
    <div class="row align-items-center mt-20">
        <div class="col-md-6">
            <h5>Stars</h5>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('admin.matrimony.add-star') }}" class="btn btn-primary">
                Add Star
            </a>
        </div>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Star</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stars as $index => $star)
                    <tr id="star-row-{{ $star->id }}">
                        <td>{{ ($stars->currentPage() - 1) * $stars->perPage() + $loop->iteration }}</td>
                        <td>{{ $star->star }}</td>
                        <td>
                            <!-- Edit Button -->
                            <a href="{{ route('admin.matrimony.edit-star', ['id' => $star->id]) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
        
                            <!-- Delete Button -->
                            <button class="btn btn-danger btn-sm delete-star" data-id="{{ $star->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">
                            <iframe src="https://lottie.host/embed/2c48b3b4-b00c-46c0-9ed3-0cd72661638d/UIT2qrxBDr.lottie"></iframe>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- Pagination Links -->
        <div class="d-flex justify-content-center mt-3">
            {{ $stars->links() }}
        </div>
    </div>
@endsection

{{-- Delete function --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".delete-star").forEach(function (button) {
            button.addEventListener("click", function () {
                let starId = this.getAttribute("data-id");
                let url = "{{ route('admin.matrimony.delete-star', ':id') }}".replace(':id', starId);

                if (confirm("Are you sure you want to delete this star?")) {
                    fetch(url, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById("star-row-" + starId).remove();
                            alert(data.message);
                        } else {
                            alert("Something went wrong!");
                        }
                    })
                    .catch(error => {
                        alert("Failed to delete star.");
                    });
                }
            });
        });
    });
</script>