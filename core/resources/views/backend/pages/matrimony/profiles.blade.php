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
                        <th>Occupation</th>
                        <th>Annual Income</th>
                        <th>Verified</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($profiles as $index => $profile)
                    <tr id="profile-{{ $profile->id }}">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $profile->name }}</td>
                        <td>{{ $profile->occupation }}</td>
                        <td>₹{{ number_format($profile->annual_income, 2) }}</td>
                        <td class="buttons">
                            @if($profile->is_verified == 1)
                                <span class="text-success">Verified</span>
                            @elseif($profile->is_verified == 2)
                                <span class="text-danger">Rejected</span>
                            @else
                                <button class="btn btn-accept" onclick="updateStatus({{ $profile->id }}, 1)">Accept</button>
                                <button class="btn btn-reject" onclick="updateStatus({{ $profile->id }}, 2)">Reject</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div> 
    </div>
@endsection

<script>
    function updateStatus(profileId, status) {
        fetch(`/matrimony/profiles/${profileId}/verify`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF Token
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json()) // Ensure JSON response
        .then(data => {
            if (data.success) {
                let row = document.getElementById("profile-" + profileId);
                let statusCell = row.querySelector(".buttons");
                statusCell.innerHTML = status === 1 
                    ? '<span class="text-success">Verified</span>' 
                    : '<span class="text-danger">Rejected</span>';
            } else {
                alert("Failed to update status!");
            }
        })
        .catch(error => console.error("Fetch error:", error));
    }
</script>  