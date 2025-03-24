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

        .fa-eye {
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
                            <!-- Eye Icon to view profile -->
                            <a href="{{ route('profile.show', $profile->id) }}" title="View Profile">
                                <i class="fas fa-eye"></i>
                            </a>
                            {{-- <a href="{{ route('profile.verify', $profile->id) }}" title="Verify Profile">
                                <i class="fas fa-check"></i>
                            </a>             --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>     
                      
        </div> 
    </div>
@endsection 