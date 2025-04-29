@extends('backend.admin-master')
@section('site-title')
    {{__('All Zodiac Signs')}}
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
            <h5>Zodiac Signs</h5>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('admin.matrimony.add-zodiac-sign') }}" class="btn btn-primary">
                Add Zodiac Sign
            </a>
        </div>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Zodiac Sign</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($zodiacSigns as $index => $zodiacSign)
                    <tr id="zodiac-sign-row-{{ $zodiacSign->id }}">
                        <td>{{ ($zodiacSigns->currentPage() - 1) * $zodiacSigns->perPage() + $loop->iteration }}</td>
                        <td>{{ $zodiacSign->zodiac_sign }}</td>
                        <td>
                            <!-- Edit Button -->
                            <a href="{{ route('admin.matrimony.edit-zodiac-sign', ['id' => $zodiacSign->id]) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
        
                            <!-- Delete Button -->
                            <button class="btn btn-danger btn-sm delete-zodiac-sign" data-id="{{ $zodiacSign->id }}">
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
            {{ $zodiacSigns->links() }}
        </div>
    </div>
@endsection

{{-- Delete function --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".delete-zodiac-sign").forEach(function (button) {
            button.addEventListener("click", function () {
                let zodiacSignId = this.getAttribute("data-id");
                let url = "{{ route('admin.matrimony.delete-zodiac-sign', ':id') }}".replace(':id', zodiacSignId);

                if (confirm("Are you sure you want to delete this zodiac sign?")) {
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
                            document.getElementById("zodiac-sign-row-" + zodiacSignId).remove();
                            alert(data.message);
                        } else {
                            alert("Something went wrong!");
                        }
                    })
                    .catch(error => {
                        alert("Failed to delete zodiac sign.");
                    });
                }
            });
        });
    });
</script>