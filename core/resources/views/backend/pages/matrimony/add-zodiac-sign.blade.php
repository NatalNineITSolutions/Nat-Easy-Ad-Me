@extends('backend.admin-master')
@section('site-title')
    @if(isset($zodiacSign))
        {{__('Edit Zodiac Sign')}}
    @else
        {{__('Add New Zodiac Sign')}}
    @endif
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        @if(isset($zodiacSign))
                            {{__('Edit Zodiac Sign')}}
                        @else
                            {{__('Add New Zodiac Sign')}}
                        @endif
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ isset($zodiacSign) ? route('admin.matrimony.update-zodiac-sign', $zodiacSign->id) : route('admin.matrimony.store-zodiac-sign') }}" method="POST">
                        @csrf
                        @if(isset($zodiacSign))
                            @method('PUT')
                        @endif

                        <div class="form-group">
                            <label for="zodiac_sign">Zodiac Sign</label>
                            <input type="text" class="form-control" id="zodiac_sign" name="zodiac_sign" 
                                   value="{{ $zodiacSign->zodiac_sign ?? old('zodiac_sign') }}" required>
                            @error('zodiac_sign')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                @if(isset($zodiacSign))
                                    {{__('Update')}}
                                @else
                                    {{__('Save')}}
                                @endif
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection