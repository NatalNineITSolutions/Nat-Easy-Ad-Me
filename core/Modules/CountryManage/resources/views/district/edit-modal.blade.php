<div class="modal fade" id="editDistrictModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.district.edit') }}" method="POST">
            @csrf

            <input type="hidden" name="district_id" id="edit_district_id">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Edit District') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">

                        {{-- Country --}}
                        <div class="col-md-6">
                            <label class="form-label">{{ __('Country') }}</label>
                            <select
                                name="edit_country"
                                id="edit_country"
                                class="form-control country_select22">
                                @foreach($all_countries as $country)
                                    <option value="{{ $country->id }}">
                                        {{ $country->country }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- State --}}
                        <div class="col-md-6">
                            <label class="form-label">{{ __('State') }}</label>
                            <select name="edit_state" id="edit_state" class="form-control state_select2_edit">
                                <option value="">{{ __('Select State') }}</option>
                            </select>
                        </div>

                        {{-- District --}}
                        <div class="col-md-6">
                            <label class="form-label">{{ __('District Name') }}</label>
                            <input
                                type="text"
                                name="edit_district"
                                id="edit_district"
                                class="form-control">
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary edit_district">
                        {{ __('Update District') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
