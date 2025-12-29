<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.district.all') }}" method="POST">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Add District') }}</h5>
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
                                name="country"
                                id="country"
                                class="form-control country_select2">
                                <option value="">{{ __('Select Country') }}</option>
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
                            <select name="state" id="state" class="form-control state_select2_add">
                                <option value="">{{ __('Select State') }}</option>
                            </select>
                        </div>

                        {{-- District --}}
                        <div class="col-md-6">
                            <label class="form-label">{{ __('District Name') }}</label>
                            <input
                                type="text"
                                name="district"
                                id="district"
                                class="form-control"
                                placeholder="{{ __('Enter district name') }}">
                        </div>

                        {{-- Status --}}
                        <div class="col-md-6">
                            <label class="form-label">{{ __('Status') }}</label>
                            <select name="status" class="form-control">
                                <option value="1">{{ __('Active') }}</option>
                                <option value="0">{{ __('Inactive') }}</option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary add_district">
                        {{ __('Add District') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
