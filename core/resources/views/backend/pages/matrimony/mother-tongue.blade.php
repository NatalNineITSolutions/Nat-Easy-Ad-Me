@extends('backend.admin-master')
@section('site-title')
    {{__('All Castes')}}
@endsection

@section('content')
    <div class="row align-items-center mt-20">
        <div class="col-md-6">
            <h5>Caste</h5>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('admin.matrimony.add-mother-tongue') }}" class="btn btn-primary">
                Add Mother Tongue
            </a>            
        </div>   
        
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Mother Tongue</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($motherTongues as $index => $motherTongue)
                    <tr>
                        <td>{{ ($motherTongues->currentPage() - 1) * $motherTongues->perPage() + $loop->iteration }}</td>
                        <td>{{ $motherTongue->mother_tongue }}</td>
                        <td>
                            <a href="{{ route('admin.matrimony.add-mother-tongue', ['id' => $motherTongue->id]) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-danger btn-sm delete-mother-tongue" data-id="{{ $motherTongue->id }}">
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
            {{ $motherTongues->links() }}
        </div>
    </div>
@endsection

{{-- Delete function --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".delete-mother-tongue").forEach(function (button) {
            button.addEventListener("click", function () {
                let motherTongueId = this.getAttribute("data-id");
                let url = "{{ route('admin.matrimony.delete-mother-tongue', ':id') }}".replace(':id', motherTongueId);

                if (confirm("Are you sure you want to delete this Mother Tongue?")) {
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
                            document.getElementById("mother-tongue-row-" + motherTongueId).remove(); // Remove row from table
                            alert(data.message);
                        } else {
                            alert("Something went wrong!");
                        }
                    })
                    .catch(error => {
                        alert("Failed to delete Mother Tongue.");
                    });
                }
            });
        });
    });
</script>