@extends('frontend.layout.master')
@section('content')
    @include('frontend.pages.dynamic.partials.dynamic-page-builder-part',['page_post' => $page_details, 'random_ad' => $random_ad,])
@endsection
