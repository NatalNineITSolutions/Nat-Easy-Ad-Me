@extends('matrimony.layouts.app')

@section('title', 'Matrimony Login')

@section('style')
    <style>
        .otp-container {
            /* background: url('bg-pattern.png') repeat; */
            background-image: url('/assets/uploads/media-uploader/bg.png');
            height: 90vh;
            padding: 50px 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .left {
            width: 50%;
            display: block;
            background-image: url('/assets/uploads/media-uploader/otp.jpeg');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            padding: 50px 0;
            height: auto;
        }

        .right {
            width: 50%;
            background: white;
            padding: 130px 0;
            display: flex;
            align-content: center;
            justify-content: center;
        }

        .login-form {
            width: 100%;
            max-width: 400px;
            text-align: center;
        }


        .login-form h3 {
            color: #cc6600;
            font-size: 22px;
            font-weight: bold;
        }

        .desp {
            font-size: 12px;
            font-weight: 500;
            color: #666;
        } 

        .form {
            margin-top: 25px;
        }

        .phone-input-container {
            display: flex;
            align-items: center;
            gap: 15px;
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

        .login-btn {
            background: #FF166C;
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

        .login-btn:hover {
            background: #fa699e;
        }

        .terms {
            font-size: 12px;
            margin-top: 20px;
            font-weight: 500;
        }

        .login-text {
            font-size: 13px;
            font-weight: 500;
        }

        .or {
            font-size: 14px;
            font-weight: 600;
            margin-top: 20px;
        }

        .otp-btn {
            background: #FF166C;
            border: none;
            outline: none;
            color: white;
            padding: 8px 12px;
            width: 100%;
            font-size: 14px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 25px;
        }

        .login-text a {
            text-decoration: none;
        }

        .terms a {
            text-decoration: none;
        }

        @media (max-width: 991px) {

            .left {
                display: none;
            }

            .right {
                padding: 120px;
                width: 100%;
            }

            .login-form {
                max-width: 100%;
            }
        }

        @media (max-width: 768px) {
            .right {
                padding: 40px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="otp-container">
        <div class="container d-flex">
            <div class="left"></div>
            <div class="right">
                <div class="login-form">
                    <h3>Secure Login to Your Account</h3>
                    <p class="desp">Access your profile, manage preferences, and connect with your perfect match effortlessly.</p>
                    
                    <form class="form">
                        
                        <div class="phone-input-container">
                            <select class="country-code" name="country_code" id="country_code">
                                <option value="+91">+91</option>
                                <option value="+1">+1</option>
                                <option value="+44">+44</option>
                                <option value="+61">+61</option>
                                <option value="+971">+971</option>
                            </select>
                        
                            <input type="tel" class="mobile-number" id="mobile" name="mobile" placeholder="Mobile Number" required>
                        </div>
                    
                        <button type="submit" class="otp-btn">Send OTP</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

 {{-- Number Validation --}}
 <script>
    const countryCodeSelect = document.getElementById("country_code");
    const mobileInput = document.getElementById("mobile");
    const submitBtn = document.getElementById("submitBtn");

    // Function to enforce max length dynamically
    function enforceMaxLength() {
        if (countryCodeSelect.value === "+91") {
            mobileInput.setAttribute("maxlength", "10");
        } else {
            mobileInput.removeAttribute("maxlength"); // Remove restriction for other countries
        }
    }

    // Restrict input to only numbers
    mobileInput.addEventListener("input", function() {
        this.value = this.value.replace(/\D/g, ""); // Remove non-numeric characters
        enforceMaxLength(); // Apply length restriction when typing
    });

    // Apply length restriction when country code changes
    countryCodeSelect.addEventListener("change", function() {
        enforceMaxLength();
    });

    // Validate on form submission
    submitBtn.addEventListener("click", function(event) {
        let mobileNumber = mobileInput.value.trim();

        if (countryCodeSelect.value === "+91" && mobileNumber.length !== 10) {
            event.preventDefault(); // Prevent form submission
            toastr.error("Indian mobile numbers must be exactly 10 digits.");
        }
    });

    // Initialize on page load
    enforceMaxLength();
</script>

@endsection