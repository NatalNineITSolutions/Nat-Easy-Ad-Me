

<?php $__env->startSection('title', 'Matrimony Registration'); ?>

<?php $__env->startSection('style'); ?>
    <style>
        .matrimony-container {
            /* background: url('bg-pattern.png') repeat; */
            background-color: #ff8800;
            padding: 50px 0;
        }

        .left {
            width: 50%;
            display: block;
            background-color: black;
            padding: 50px 0;
            height: auto;
        }

        .right {
            width: 50%;
            background: white;
            padding: 30px 0;
            display: flex;
            align-content: center;
            justify-content: center;
        }

        .register-form {
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        /* Headings */
        .register-form h3 {
            color: #cc6600;
            font-size: 22px;
            font-weight: bold;
        }

        .desp p {
            font-size: 14px;
            font-weight: 500;
            color: #666;
        } 

        .form {
            margin-top: 25px;
        }

        /* Input Fields */
        .input-group {
            display: flex;
            align-items: center;    
            position: relative;
            margin: 10px 0;
        }

        input, select:focus {
            border: 1px solid #ccc;
            outline: none;
        }

        .row {
            align-items: center
        }

        .input-group input {
            width: 100%;
            padding: 5px 12px;
            border: 1px solid #ccc;
            font-size: 12px;
            font-weight: 600;
        }

        .input-group span {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #777;
        }

        /* Select Dropdown */
        select {
            width: 100%;
            padding: 5px 12px;
            border: 1px solid #ccc;
            font-size: 12px;
            font-weight: 600;
            margin: 8px 0;
            appearance: none;
            color: #777;
        }

        /* Register Button */
        .register-btn {
            background: #ff8800;
            color: white;
            border: none;
            padding: 8px 12px;
            width: 100%;
            font-size: 14px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.3s;
        }

        .register-btn:hover {
            background: #cc6600;
        }

        /* Terms & Conditions */
        .terms,
        .privacy,
        .login {
            font-size: 13px;
            color: #666;
            margin-top: 10px;
        }

        .terms {
            font-size: 12px;
        }

        .terms a,
        .privacy a,
        .login a {
            color: #007bff;
            text-decoration: none;
        }

        .date-input-container {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .date-input-container input {
            width: 100%;
            padding: 5px 12px; /* Space for icon */
            border: 1px solid #ccc;
            font-size: 12px;
            font-weight: 600;
        }

        .date-input-container input:focus {
            border-color: #007bff;
            background-color: #fff;
        }

        .date-input-container .calendar-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: #aaa;
            cursor: pointer;
        }

        .phone-input-container {
            display: flex;
            align-items: center;
            gap: 15px;
            border-radius: 5px;
            overflow: hidden;
            background-color: #fff;
            width: 100%;
            max-width: 400px; /* Adjust width as needed */
        }

        .phone-input-container select {
            border: none;
            padding: 5px 12px;
            font-size: 12px;
            font-weight: 600;
            background-color: #f8f9fa;
            cursor: pointer;
            width: 80px; /* Adjust width of country code dropdown */
            text-align: center;
        }

        .phone-input-container input {
            flex: 1;
            padding: 5px 12px;
            font-size: 12px;
            font-weight: 600;
            outline: none;
            background-color: #fff;
            border: 1px solid #ccc;
        }

        .phone-input-container select:focus,
        .phone-input-container input:focus {
            outline: none;
        }

        .success-message {
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 768px) {

            .left {
                display: none;
            }

            .right {
                padding: 20px;
                width: 100%;
            }

            .register-form {
                max-width: 100%;
            }

            .phone-input-container {
                max-width: 100%;
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section class="matrimony-container">
        <div class="container d-flex">
            <div class="left"></div>
            <div class="right">
                <div class="register-form">
                    <h3>Find Your Perfect Match</h3>
                    <p class="desp">Join India's most trusted matrimonial platform</p>
                    <form class="form" action="<?php echo e(route('matrimony.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="input-group">
                            <input type="text" placeholder="Name" name="name" required>
                        </div>
                    
                        <div class="input-group">
                            <input type="password" placeholder="Password" name="password" required>
                        </div>
                    
                        <div class="input-group">
                            <input type="email" placeholder="Email" name="email" required>
                        </div>
                    
                        <div class="row">
                            <div class="col-6">
                                <select name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" <?php echo e(old('gender') == 'Male' ? 'selected' : ''); ?>>Male</option>
                                    <option value="Female" <?php echo e(old('gender') == 'Female' ? 'selected' : ''); ?>>Female</option>
                                </select>
                            </div>
                    
                            <div class="col-6">
                                <div class="date-input-container">
                                    <input type="date" name="dob" id="dob" required>
                                    <span class="calendar-icon">&#128197;</span>
                                </div>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-6">
                                <select name="country" required>
                                    <option value="">Select Country</option>
                                    <option value="India">India</option>
                                    <option value="USA">USA</option>
                                </select>
                            </div>
                    
                            <div class="col-6">
                                <select name="location" required>
                                    <option value="">Select Location</option>
                                    <option value="Chennai">Chennai</option>
                                    <option value="Bangalore">Bangalore</option>
                                </select>
                            </div>
                        </div>
                    
                        <div class="phone-input-container">
                            <select class="country-code" name="country_code">
                                <option value="+91">+91</option>
                                <option value="+1" >+1</option>
                                <option value="+44" >+44</option>
                                <option value="+61" >+61</option>
                                <option value="+971">+971</option>
                            </select>
                    
                            <input type="tel" class="mobile-number" name="mobile" placeholder="Mobile Number" value="<?php echo e(old('mobile')); ?>" required>
                        </div>
                    
                        <button type="submit" class="register-btn">REGISTER FREE</button>
                    
                        <p class="terms">By clicking on Register Free, you agree to the <a href="#">Terms & Conditions</a>.</p>
                        <p class="login">Already a member? <a href="#">Login Now</a></p>
                    </form>
                    
                    <?php if(session('success')): ?>
                        <p class="success-message text-success"><?php echo e(session('success')); ?></p>
                    <?php endif; ?>                    
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const dobInput = document.getElementById("dob");
            const calendarIcon = document.querySelector(".calendar-icon");

            // Open date picker when clicking the icon
            calendarIcon.addEventListener("click", function () {
                dobInput.showPicker(); // Opens the date picker directly
            });
        });
    </script>

    <script>
        window.history.pushState(null, "", window.location.href);
        window.onpopstate = function() {
            window.history.pushState(null, "", window.location.href);
        };
    </script>

<script>
    // Display Toastr notifications
    <?php if(session('success')): ?>
        toastr.success("<?php echo e(session('success')); ?>");
    <?php endif; ?>

    <?php if(session('error')): ?>
        toastr.error("<?php echo e(session('error')); ?>");
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            toastr.error("<?php echo e($error); ?>");
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('matrimony.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\easyadme\core\resources\views/matrimony/register.blade.php ENDPATH**/ ?>