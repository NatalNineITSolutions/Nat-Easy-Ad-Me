@extends('matrimony.layouts.app')

@section('title', 'Matrimony Home')

@section('style')
<style>
    body {
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
    }
    .content {
        text-align: center;
        padding: 20px;
    }
</style>
@endsection

@section('content')
    <h2>Welcome to the Matrimony Homepage</h2>
    <p>Find your perfect match!</p>
@endsection

@section('script')
    <script>
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.pushState(null, null, location.href);
        };
    </script>
@endsection