@extends('matrimony.layouts.app')

@section('title', 'Matrimony Pricing')

@section('style')
    <style>
        /* Gradient Background */
        .pricing-section {
            background: linear-gradient(to right, #6d0f7b, #e44042); /* Adjusted Gradient Colors */
            color: white;
            text-align: center;
            padding: 80px 20px;
            position: relative;
        }

        /* Small Decorative Circles */
        .pricing-section::before, .pricing-section::after {
            content: "";
            position: absolute;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .pricing-section::before {
            top: 20px;
            left: 30px;
        }

        .pricing-section::after {
            bottom: 30px;
            right: 40px;
        }

        /* Heading Styles */
        .pricing-section h2 {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .pricing-section h3 {
            font-size: 1.8rem;
            font-weight: 600;
        }

        .pricing-section p {
            font-size: 1rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 10px auto;
        }

        /* Button Styling */
        .pricing-btn {
            background-color: white;
            color: #e44042;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
            display: inline-block;
            margin-top: 15px;
        }

        .pricing-btn:hover {
            background-color: #f5f5f5;
            color: #6d0f7b;
        }

        .pricing-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 25px;
            transition: 0.3s;
        }
        .pricing-card:hover {
            transform: scale(1.02);
        }
        .pricing-card .btn {
            width: 100%;
            border-radius: 30px;
            font-weight: bold;
            padding: 10px;
        }
        .gold-plan {
            position: relative;
            border: 2px solid #d4af37;
        }
        .gold-plan .btn {
            background: #d9534f;
            color: white;
        }
        .gold-plan .badge {
            background: #d4af37;
            color: white;
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 12px;
            padding: 5px 10px;
            border-radius: 20px;
        }

        .box-list {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .box-list li {
            font-size: 12px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .pricing-section h2 {
                font-size: 2rem;
            }
            .pricing-section h3 {
                font-size: 1.5rem;
            }
        }
    </style>
@endsection

@section('content')
    <section class="pricing-section">
        <h3>PRICING</h3>
        <h2>Get Started</h2>
        <h3>Pick your Plan Now</h3>
        <p>Choose a plan that fits your needs. Get access to premium features and start your journey today!</p>
    </section>

    <div class="container py-5">
        <div class="row justify-content-center">
            @foreach ($memberships as $membership)
                <div class="col-md-4 d-flex">
                    <div class="pricing-card w-100 h-100 d-flex flex-column">
                        <h4>{{ $membership->title }}</h4>
                        <p>{{ $membership->description ?? 'No description available.' }}</p>
                        <button class="btn btn-light">Get Started</button>
                        <h3 class="mt-3">₹{{ $membership->price }}<span>/mo</span></h3>
                        <ul class="list-unstyled mt-3 flex-grow-1 box-list">
                            @if ($membership->features)
                                @foreach (explode(',', $membership->features) as $feature)
                                    <li>✅ {{ trim($feature) }}</li>
                                @endforeach
                            @else
                                <li>No features available.</li>
                            @endif
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection