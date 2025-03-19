@extends('frontend.layout.master')

@section('site_title')
    {{ __('Add New Member') }}
@endsection

@section('content')
<div class="container">
    <h2>{{ __('Add New Member') }}</h2>

    <form action="{{ route('mlm.registerNewMember') }}" method="POST">
        @csrf

        <!-- Hidden fields to carry sponsor and position information -->
        <input type="hidden" name="sponsor_id" value="{{ $sponsor->id }}">
        <input type="hidden" name="position" value="{{ $position }}">

        <div class="form-group">
            <label for="first_name">{{ __('First Name') }}</label>
            <input type="text" name="first_name" id="first_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="last_name">{{ __('Last Name') }}</label>
            <input type="text" name="last_name" id="last_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">{{ __('Email') }}</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <!-- Add additional fields as required -->

        <button type="submit" class="btn btn-primary">{{ __('Register') }}</button>
    </form>
</div>
@endsection
