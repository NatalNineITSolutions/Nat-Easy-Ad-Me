@extends('backend.admin-master')
@section('site-title')
    {{__('All Religions')}}
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
            <h5>Religion</h5>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('admin.matrimony.add-religion') }}" class="btn btn-primary">
                Add Religion
            </a>
        </div>
        <table class="table table-bordered mt-25">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Religion</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($religions as $index => $religion)
                    <tr id="religion-row-{{ $religion->id }}">
                        <td>{{ $religions->firstItem() + $index }}</td>
                        <td>{{ $religion->religion }}</td>
                        <td class="icons">
                            <!-- Edit Button -->
                            <a href="{{ route('admin.matrimony.edit-religion', $religion->id) }}"
                                class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>

                            <!-- Delete Button -->
                            <button class="btn btn-danger btn-sm delete-religion" data-id="{{ $religion->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">
                            <iframe
                                src="https://lottie.host/embed/2c48b3b4-b00c-46c0-9ed3-0cd72661638d/UIT2qrxBDr.lottie"></iframe>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center mt-3">
            {{ $religions->links() }}
        </div>
    </div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".delete-religion").forEach(function (button) {
            button.addEventListener("click", function () {
                let religionId = this.getAttribute("data-id");
                let url = "{{ route('admin.matrimony.delete-religion', ':id') }}".replace(':id', religionId);

                if (confirm("Are you sure you want to delete this religion?")) {
                    fetch(url, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Accept": "application/json",
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ _token: "{{ csrf_token() }}" })
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                // Remove the row from the table
                                const row = document.getElementById("religion-row-" + religionId);
                                if (row) {
                                    row.remove();
                                }
                                // Show success message
                                toastr.success(data.message);

                                // Reload the page if it's the last item on the page
                                if (document.querySelectorAll("tbody tr").length === 1) { // 1 because empty row remains
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 1500);
                                }
                            } else {
                                toastr.error(data.message || "Something went wrong!");
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            toastr.error("Failed to delete religion. Please try again.");
                        });
                }
            });
        });
    });
</script>