

<?php $__env->startSection('title', 'Matrimony Pricing'); ?>

<?php $__env->startSection('style'); ?>
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

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section class="pricing-section">
        <h3>PRICING</h3>
        <h2>Get Started</h2>
        <h3>Pick your Plan Now</h3>
        <p>Choose a plan that fits your needs. Get access to premium features and start your journey today!</p>
        
    </section>

    <div class="container py-5">
        <div class="row justify-content-center">
            
            <!-- Free Plan -->
            <div class="col-md-4 d-flex">
                <div class="pricing-card w-100 h-100 d-flex flex-column">
                    <h4>Free</h4>
                    <p>Printer took a type and scrambled</p>
                    <button class="btn btn-light">Get Started</button>
                    <h3 class="mt-3">₹0<span>/mo</span></h3>
                    <ul class="list-unstyled mt-3 flex-grow-1 box-list">
                        <li>✅ 5 Premium Profiles view /mo</li>
                        <li>✅ Free user profile can view</li>
                        <li class="cross-icon">❌ View contact details</li>
                        <li class="cross-icon">❌ Send interest</li>
                        <li class="cross-icon">❌ Start Chat</li>
                    </ul>
                </div>
            </div>
    
            <!-- Gold Plan -->
            <div class="col-md-4 d-flex">
                <div class="pricing-card gold-plan w-100 h-100 d-flex flex-column">
                    <span class="badge">Most popular plan</span>
                    <h4>Gold</h4>
                    <p>Printer took a type and scrambled</p>
                    <button class="btn">Get Started</button>
                    <h3 class="mt-3">₹349<span>/mo</span></h3>
                    <ul class="list-unstyled mt-3 flex-grow-1 box-list">
                        <li class="check-icon">✅ 20 Premium Profiles view /mo</li>
                        <li class="check-icon">✅ Free user profile can view</li>
                        <li class="check-icon">✅ View contact details</li>
                        <li class="check-icon">✅ Send interest</li>
                        <li class="check-icon">✅ Start Chat</li>
                    </ul>
                </div>
            </div>
    
            <!-- Platinum Plan -->
            <div class="col-md-4 d-flex">
                <div class="pricing-card w-100 h-100 d-flex flex-column">
                    <h4>Platinum</h4>
                    <p>Printer took a type and scrambled</p>
                    <button class="btn btn-light">Get Started</button>
                    <h3 class="mt-3">₹549<span>/mo</span></h3>
                    <ul class="list-unstyled mt-3 flex-grow-1 box-list">
                        <li class="check-icon">✅ 50 Premium Profiles view /mo</li>
                        <li class="check-icon">✅ Free user profile can view</li>
                        <li class="check-icon">✅ View contact details</li>
                        <li class="check-icon">✅ Send interest</li>
                        <li class="check-icon">✅ Start Chat</li>
                    </ul>
                </div>
            </div>
    
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('matrimony.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/matrimony/price.blade.php ENDPATH**/ ?>