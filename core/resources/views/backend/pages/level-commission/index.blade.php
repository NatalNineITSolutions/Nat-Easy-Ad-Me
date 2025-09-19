@extends('backend.admin-master')
@section('site-title')
    {{ __('Level Based Commission') }}
@endsection

@section('content')
<div class="container-fluid">
    <div class="card mt-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">{{ __('Level Based Commission Management') }}</h4>
            <!-- Trigger Modal -->
            <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#createCommissionModal">
                <i class="las la-plus-circle"></i> {{ __('Create Level Commission') }}
            </button>
        </div>
        <div class="card-body">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">{{ __('Level Name') }}</th>
                        <th scope="col">{{ __('Commission (%)') }}</th>
                        <th scope="col" class="text-center">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($commissions as $commission)
                        <tr>
                            <td>{{ $commission->level_name }}</td>
                            <td>{{ $commission->commission }}%</td>
                            <td class="text-center">
                                <!-- Edit Button -->
                                <button 
                                    class="btn btn-sm btn-warning edit-btn"
                                    data-id="{{ $commission->id }}"
                                    data-level="{{ $commission->level_name }}"
                                    data-commission="{{ $commission->commission }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#createCommissionModal">
                                    <i class="las la-edit"></i> Edit
                                </button>

                                <!-- Delete Button -->
                                <form action="{{ route('admin.level.commission.delete', $commission->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this commission?')">
                                        <i class="las la-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">No commissions found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Commission Modal -->
<div class="modal fade" id="createCommissionModal" tabindex="-1" aria-labelledby="createCommissionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="commissionForm" action="{{ route('admin.level.commission.store') }}" method="POST"> 
            @csrf
            @method('POST') <!-- default for create -->
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="createCommissionLabel">{{ __('Create Level Commission') }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="commission_id" name="commission_id">
                    <div class="mb-3">
                        <label for="level_name" class="form-label">{{ __('Level Name') }}</label>
                        <input type="text" class="form-control" id="level_name" name="level_name" placeholder="Enter level name" required>
                    </div>
                    <div class="mb-3">
                        <label for="commission" class="form-label">{{ __('Commission (%)') }}</label>
                        <input type="number" class="form-control" id="commission" name="commission" placeholder="Enter commission %" step="0.01" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary" id="saveBtn">{{ __('Save') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById('commissionForm');
        const modalTitle = document.getElementById('createCommissionLabel');
        const saveBtn = document.getElementById('saveBtn');

        // When clicking "Edit"
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function () {
                let id = this.getAttribute('data-id');
                let level = this.getAttribute('data-level');
                let commission = this.getAttribute('data-commission');

                // Fill form
                document.getElementById('commission_id').value = id;
                document.getElementById('level_name').value = level;
                document.getElementById('commission').value = commission;

                // Change form action to update
                form.action = `/level-commission/update/${id}`;
                form.querySelector('input[name="_method"]').value = 'PUT';

                // Update modal title & button
                modalTitle.innerText = "Edit Level Commission";
                saveBtn.innerText = "Update";
            });
        });

        // When opening modal normally (Create button)
        document.querySelector('[data-bs-target="#createCommissionModal"]').addEventListener('click', function () {
            // Reset form
            form.reset();
            document.getElementById('commission_id').value = "";

            // Reset action to store
            form.action = `{{ route('admin.level.commission.store') }}`;
            form.querySelector('input[name="_method"]').value = 'POST';

            modalTitle.innerText = "Create Level Commission";
            saveBtn.innerText = "Save";
        });
    });
</script>
@endsection