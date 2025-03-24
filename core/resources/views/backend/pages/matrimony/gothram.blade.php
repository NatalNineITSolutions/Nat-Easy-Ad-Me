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
            <h5>Gothram</h5>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{route('admin.matrimony.add-gothram') }}" class="btn btn-primary">
                Add Gothram
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Gothram</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($gothrams as $index => $gothram)
                        <tr id="gothram-row-{{ $gothram->id }}">
                            <td>{{ $gothrams->firstItem() + $index }}</td>
                            <td>{{ $gothram->gothram }}</td>
                            <td>
                                <!-- Edit Button -->
                                <a href="{{ route('admin.matrimony.add-gothram', ['id' => $gothram->id]) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
        
                                <!-- Delete Button -->
                                <button class="btn btn-danger btn-sm delete-gothram" data-id="{{ $gothram->id }}">
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
        </div>
        
        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {{ $gothrams->links() }}
        </div>
                
    </div>
@endsection

{{-- Delete function --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".delete-gothram").forEach(function (button) {
            button.addEventListener("click", function () {
                let gothramId = this.getAttribute("data-id");
                let url = "{{ route('admin.matrimony.delete-gothram', ':id') }}".replace(':id', gothramId);

                if (confirm("Are you sure you want to delete this gothram?")) {
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
                            document.getElementById("gothram-row-" + gothramId).remove(); // Remove row from table
                            alert(data.success);
                        } else {
                            alert(data.error || "Something went wrong!");
                        }
                    })
                    .catch(error => {
                        alert("Failed to delete gothram.");
                    });
                }
            });
        });
    });
</script>