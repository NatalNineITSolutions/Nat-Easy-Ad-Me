@extends('backend.admin-master')
@section('site-title')
    {{__('All Castes')}}
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
            <h5>Caste</h5>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('admin.matrimony.add-caste') }}" class="btn btn-primary">
                Add Caste
            </a>
        </div>
        <table class="table table-bordered mt-25">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Caste</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($castes as $index => $caste)
                    <tr id="caste-row-{{ $caste->id }}">
                        <td>{{ $castes->firstItem() + $index }}</td>
                        <td>{{ $caste->caste }}</td>
                        <td class="icons">
                            <!-- Edit Button -->
                            <a href="{{ route('admin.matrimony.add-caste', ['id' => $caste->id]) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <!-- Delete Button -->
                            <button class="btn btn-danger btn-sm delete-caste" data-id="{{ $caste->id }}">
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
            {{ $castes->links() }}
        </div>
                
    </div>
@endsection

{{-- Delete function --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".delete-caste").forEach(function (button) {
            button.addEventListener("click", function () {
                let casteId = this.getAttribute("data-id");
                let url = "{{ route('admin.matrimony.delete-caste', ':id') }}".replace(':id', casteId);

                if (confirm("Are you sure you want to delete this caste?")) {
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
                            document.getElementById("caste-row-" + casteId).remove(); // Remove row from table
                            alert(data.message);
                        } else {
                            alert("Something went wrong!");
                        }
                    })
                    .catch(error => {
                        alert("Failed to delete caste.");
                    });
                }
            });
        });
    });
</script>