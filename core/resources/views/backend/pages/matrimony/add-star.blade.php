@extends('backend.admin-master')
@section('site-title')
    @if(isset($star))
        {{__('Edit Star')}}
    @else
        {{__('Add New Star')}}
    @endif
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        @if(isset($star))
                            {{__('Edit Star')}}
                        @else
                            {{__('Add New Star')}}
                        @endif
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ isset($star) ? route('admin.matrimony.update-star', $star->id) : route('admin.matrimony.store-star') }}" method="POST">
                        @csrf
                        @if(isset($star))
                            @method('PUT')
                        @endif

                        <div class="form-group">
                            <label for="star">Star</label>
                            <input type="text" class="form-control" id="star" name="star" 
                                   value="{{ $star->star ?? old('star') }}" required>
                            @error('star')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                @if(isset($star))
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