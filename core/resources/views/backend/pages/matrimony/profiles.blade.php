@extends('backend.admin-master')
@section('site-title')
    {{__('All User Listings')}}
@endsection

@section('style')
    <style>
         table {
            width: 100%;
            border-collapse: collapse;
        } 

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            font-weight: bold;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9; /* Mild background for even rows */
        }

        h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 30px;
        }

        .text-success {
            font-size: 14px;
            font-weight: 600;
        }

        tbody td {
            font-size: 14px;
            font-weight: 600;
            color: black;
        }

        .buttons {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .btn {
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-accept {
            background-color: green;
            color: white;
        }

        .btn-reject {
            background-color: red;
            color: white;
        }

        .btn-accept:hover {
            background-color: green;
            color: white;
        }

        .fa-eye,
        .fa-check {
            margin-right: 15px;
        }

        .btn-reject:hover {
            background-color: red;
            color: white;
        }
    </style>
@endsection

@section('content')
    <div class="row g-4 mt-0">
        <div class="col-xl-12 col-lg-12">
            <h3>Profile Lists</h3>
            <table>
                <thead>
                    <tr>
                        <th>Sno</th>
                        <th>Name</th>
                        <th>Action</th> <!-- New Action Column -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($profiles as $index => $profile)
                    <tr id="profile-{{ $profile->id }}">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $profile->name }}</td>
                        <td class="action">
                            <!-- Eye Icon to View Profile (Always Visible) -->
                            <a href="{{ route('profile.show', $profile->id) }}" title="View Profile">
                                <i class="fas fa-eye"></i>
                            </a>
                        
                            <!-- If Profile is Verified, Show "Profile Verified" Text and Hide Buttons -->
                            @if($profile->is_verified == 1)
                                <span class="text-success">Profile Verified</span>
                            @elseif($profile->is_verified == 2)
                                <span class="text-danger">Profile Rejected</span>
                            @else
                                <!-- Show Tick Button Only If Not Verified -->
                                <a href="#" class="verify-profile" data-id="{{ $profile->id }}" title="Verify Profile">
                                    <i class="fas fa-check"></i>
                                </a>
                        
                                <!-- Show Cross Button Only If Not Verified -->
                                <a href="#" class="reject-profile text-danger" data-id="{{ $profile->id }}" title="Reject Profile">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </td>                        
                    </tr>
                    @endforeach
                </tbody>
            </table>               
        </div> 
    </div>

    <!-- Rejection Reason Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Reject Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="rejectProfileId">
                    <label for="rejectReason">Reason for Rejection:</label>
                    <textarea id="rejectReason" class="form-control" rows="3"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmReject">Reject</button>
                </div>
            </div>
        </div>
    </div>
@endsection 

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- <script>
    $(document).ready(function(){
    $(document).on('click', '.verify-profile', function(e){
        e.preventDefault();
        var profileId = $(this).data('id');
        var $button = $(this); // Reference to the clicked button

        $.ajax({
            url: "{{ route('profile.verify') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: profileId
            },
            success: function(response) {
                if(response.success) {
                    alert("Profile Verified Successfully!");

                    // Replace tick button with "Profile Verified" text
                    $button.replaceWith('<span class="text-success">Profile Verified</span>');
                } else {
                    alert("Error verifying profile.");
                }
            },
            error: function(xhr) {
                console.log("AJAX Error:", xhr.responseText);
                alert("Something went wrong.");
            }
        });
    });
});
</script> --}}

<script>
    $(document).ready(function(){
    // Verify Profile
    $(document).on('click', '.verify-profile', function(e){
        e.preventDefault();
        var profileId = $(this).data('id');
        var $actionCell = $(this).closest('.action');

        $.ajax({
            url: "{{ route('profile.verify') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: profileId
            },
            success: function(response) {
                if(response.success) {
                    alert("Profile Verified Successfully!");
                    $actionCell.find('.verify-profile, .reject-profile').remove();
                    $actionCell.append('<span class="text-success">Profile Verified</span>');
                } else {
                    alert("Error verifying profile.");
                }
            },
            error: function(xhr) {
                console.log("AJAX Error:", xhr.responseText);
                alert("Something went wrong.");
            }
        });
    });

    // Show Rejection Modal
    $(document).on('click', '.reject-profile', function(e){
        e.preventDefault();
        var profileId = $(this).data('id');
        $('#rejectProfileId').val(profileId);
        $('#rejectModal').modal('show');
    });

    // Confirm Rejection
    $('#confirmReject').click(function(){
        var profileId = $('#rejectProfileId').val();
        var rejectReason = $('#rejectReason').val();
        var $actionCell = $('.reject-profile[data-id="'+profileId+'"]').closest('.action');

        if (rejectReason.trim() === '') {
            alert("Please enter a reason for rejection.");
            return;
        }

        $.ajax({
            url: "{{ route('profile.reject') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: profileId,
                reason: rejectReason
            },
            success: function(response) {
                if(response.success) {
                    alert("Profile Rejected Successfully!");
                    $('#rejectModal').modal('hide');

                    // Replace tick & cross icons with "Profile Rejected"
                    $actionCell.find('.verify-profile, .reject-profile').remove();
                    $actionCell.append('<span class="text-danger">Profile Rejected</span>');
                } else {
                    alert("Error rejecting profile.");
                }
            },
            error: function(xhr) {
                console.log("AJAX Error:", xhr.responseText);
                alert("Something went wrong.");
            }
        });
    });
});
</script>
