@extends('backend.admin-master')

@section('site-title')
    {{ __('Import District') }}
@endsection

@section('content')
<div class="row g-4">
    <div class="col-xl-12">
        <div class="dashboard__card bg__white padding-20 radius-10">

            <h4 class="dashboard__inner__header__title">
                {{ __('Import District CSV') }}
            </h4>

            <x-validation.error/>

            {{-- STEP 1: Upload CSV --}}
            @if(!isset($import_data))
            <form action="{{ route('admin.district.import.csv.update.settings') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <div class="form-group mt-3">
                    <label>{{ __('Upload CSV File') }}</label>
                    <input type="file" name="csv_file" class="form-control" required>
                </div>

                <button class="btn btn-primary mt-3">
                    {{ __('Upload & Map Fields') }}
                </button>
            </form>
            @endif

            {{-- STEP 2: Map CSV --}}
            @if(isset($import_data))
            <form action="{{ route('admin.district.import.database') }}"
                  method="POST">
                @csrf

                <div class="row g-3 mt-3">

                    {{-- Country --}}
                    <div class="col-md-4">
                        <label>{{ __('Country') }}</label>
                        <select name="country_id" class="form-control" required>
                            <option value="">{{ __('Select Country') }}</option>
                            @foreach($all_countries as $country)
                                <option value="{{ $country->id }}">
                                    {{ $country->country }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- State --}}
                    <div class="col-md-4">
                        <label>{{ __('State') }}</label>
                        <select name="state_id" class="form-control" required>
                            <option value="">{{ __('Select State') }}</option>
                            @foreach($all_states as $state)
                                <option value="{{ $state->id }}">
                                    {{ $state->state }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-4">
                        <label>{{ __('Status') }}</label>
                        <select name="status" class="form-control">
                            <option value="1">{{ __('Active') }}</option>
                            <option value="0">{{ __('Inactive') }}</option>
                        </select>
                    </div>

                    {{-- CSV COLUMN --}}
                    <div class="col-md-6">
                        <label>{{ __('District Column') }}</label>
                        <select name="district" class="form-control" required>
                            @foreach($import_data[0] as $key => $column)
                                <option value="{{ $column }}">
                                    {{ $column }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <button class="btn btn-success mt-4">
                    {{ __('Import Districts') }}
                </button>
            </form>
            @endif

        </div>
    </div>
</div>
@endsection
