@extends('frontend.layout.master')
@section('site-title')
    {{ $listing->title }} - Resume
@endsection

@section('page-title')
    {{ __('Resume') }}
@endsection

@section('inner-title')
    {{ $listing->title }}
@endsection

@section('content')
    <div class="resume-container section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="resume-header text-center mb-5">
                        <h1 class="resume-name">{{ $listing->title }}</h1>
                        @if($listing->image)
                            {!! render_image_markup_by_attachment_id($listing->image, 'resume-photo rounded-circle mt-3', 'thumb') !!}
                        @endif
                    </div>

                    <!-- Contact Information -->
                    <div class="resume-section mb-5">
                        <h2 class="section-title">{{ __('Contact Information') }}</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>{{ __('Email:') }}</strong> {{ $listing->email }}</p>
                                <p><strong>{{ __('Phone:') }}</strong> {{ $listing->phone }}</p>
                                <p><strong>{{ __('Location:') }}</strong> {{ $listing->location }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>{{ __('Availability:') }}</strong>
                                    {{ \Carbon\Carbon::parse($listing->availability_date)->format('j F Y') }}</p>
                                <p><strong>{{ __('Expected Salary:') }}</strong>
                                    {{ amount_with_currency_symbol($listing->expected_salary) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Professional Summary -->
                    <div class="resume-section mb-5">
                        <h2 class="section-title">{{ __('Professional Summary') }}</h2>
                        <div class="section-content">
                            {!! $listing->summary !!}
                        </div>
                    </div>

                    <!-- Work Experience -->
                    <div class="resume-section mb-5">
                        <h2 class="section-title">{{ __('Work Experience') }}</h2>
                        <div class="section-content">
                            {!! $listing->work_experience !!}
                        </div>
                    </div>

                    <!-- Education -->
                    <div class="resume-section mb-5">
                        <h2 class="section-title">{{ __('Education') }}</h2>
                        <div class="section-content">
                            {!! $listing->education !!}
                        </div>
                    </div>

                    <!-- Skills -->
                    <div class="resume-section mb-5">
                        <h2 class="section-title">{{ __('Skills') }}</h2>
                        <div class="section-content">
                            {!! $listing->skills !!}
                        </div>
                    </div>

                    @if($listing->certifications)
                        <div class="resume-section mb-5">
                            <h2 class="section-title">{{ __('Certifications') }}</h2>
                            <div class="section-content">
                                {!! $listing->certifications !!}
                            </div>
                        </div>
                    @endif

                    @if($listing->projects)
                        <div class="resume-section mb-5">
                            <h2 class="section-title">{{ __('Projects') }}</h2>
                            <div class="section-content">
                                {!! $listing->projects !!}
                            </div>
                        </div>
                    @endif

                    @if($listing->portfolio_links)
                        <div class="resume-section mb-5">
                            <h2 class="section-title">{{ __('Portfolio Links') }}</h2>
                            <div class="section-content">
                                {!! $listing->portfolio_links !!}
                            </div>
                        </div>
                    @endif

                    <!-- Additional Information -->
                    <div class="resume-section mb-5">
                        <h2 class="section-title">{{ __('Additional Information') }}</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>{{ __('Work Preference:') }}</strong> {{ ucfirst($listing->work_preference) }}
                                </p>
                                <p><strong>{{ __('Work Authorization:') }}</strong> {{ $listing->work_authorization }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>{{ __('Willing to Relocate:') }}</strong>
                                    {{ $listing->relocation_willingness ? __('Yes') : __('No') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        .resume-container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .resume-header {
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
        }

        .resume-name {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 10px;
        }

        .resume-photo {
            border: 5px solid #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 1.8rem;
            color: #2c3e50;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .section-content {
            padding-left: 20px;
        }

        .section-content p {
            margin-bottom: 10px;
        }
    </style>
@endsection