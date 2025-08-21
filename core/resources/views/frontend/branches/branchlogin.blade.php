<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        /* Your existing CSS remains the same */
        :root {
            --heading-color: #1A1D2B;
            --primary-color: #4A6CF7;
            --secondary-color: #64748B;
            --border-color: #D0D5DD;
            --background-color: #F8FAFC;
            --white: #FFFFFF;
            --error-color: #EF4444;
            --success-color: #10B981;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background-color: var(--background-color);
            color: var(--heading-color);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-container {
            display: flex;
            max-width: 1000px;
            width: 100%;
            background: var(--white);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .login-left {
            flex: 1;
            background: linear-gradient(135deg, var(--primary-color), #2D4FCC);
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .login-left::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }
        
        .login-left::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 250px;
            height: 250px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }
        
        .login-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 15px;
            position: relative;
            z-index: 1;
        }
        
        .login-description {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
        }
        
        .login-image {
            text-align: center;
            margin-top: 30px;
            position: relative;
            z-index: 1;
        }
        
        .login-image img {
            max-width: 100%;
            height: auto;
        }
        
        .login-right {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-logo {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 10px;
        }
        
        .login-subtitle {
            color: var(--secondary-color);
            font-size: 16px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--heading-color);
        }
        
        .input-group {
            position: relative;
        }
        
        .input-group input {
            width: 100%;
            padding: 12px 45px 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .input-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(74, 108, 247, 0.1);
        }
        
        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--secondary-color);
        }
        
        .toggle-password {
            cursor: pointer;
        }
        
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
        }
        
        .remember-me input {
            margin-right: 8px;
        }
        
        .forgot-password {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }
        
        .forgot-password:hover {
            text-decoration: underline;
        }
        
        .login-button {
            width: 100%;
            padding: 14px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        
        .login-button:hover {
            background-color: #3B5BD9;
        }
        
        .error-message {
            color: var(--error-color);
            font-size: 14px;
            margin-top: 5px;
            display: none;
        }
        
        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
        }
        
        .alert-danger {
            background-color: #FEF2F2;
            color: var(--error-color);
            border: 1px solid #FECACA;
        }
        
        .alert-success {
            background-color: #ECFDF5;
            color: var(--success-color);
            border: 1px solid #A7F3D0;
        }
        
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }
            
            .login-left {
                padding: 30px;
            }
            
            .login-right {
                padding: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-left">
            <h2 class="login-title">Branch Management System</h2>
            <p class="login-description">Access your branch dashboard to manage inventory, sales, and customer relationships.</p>
            <div class="login-image">
                <svg width="250" height="200" viewBox="0 0 500 400" xmlns="http://www.w3.org/2000/svg">
                    <path d="M250,50 C350,30 450,80 450,150 C450,220 380,250 300,230 C300,280 250,320 200,300 C150,280 100,220 100,150 C100,80 150,70 250,50 Z" fill="rgba(255,255,255,0.2)" />
                    <rect x="200" y="150" width="100" height="120" rx="10" fill="rgba(255,255,255,0.8)" />
                    <rect x="220" y="180" width="60" height="10" rx="5" fill="#4A6CF7" />
                    <rect x="220" y="200" width="60" height="10" rx="5" fill="#4A6CF7" />
                    <rect x="220" y="220" width="60" height="10" rx="5" fill="#4A6CF7" />
                    <circle cx="250" cy="100" r="40" fill="rgba(255,255,255,0.8)" />
                    <path d="M230,90 C230,80 240,75 245,80 C250,85 260,80 260,90 C260,100 250,105 245,100 C240,95 230,100 230,90 Z" fill="#4A6CF7" />
                </svg>
            </div>
        </div>
        
        <div class="login-right">
            <div class="login-header">
                <div class="login-logo">Branch Login</div>
                <p class="login-subtitle">Sign in to your branch account</p>
            </div>
            
            <div class="alert alert-danger" id="errorAlert"></div>
            <div class="alert alert-success" id="successAlert"></div>
            
            <form id="branchLoginForm" action="{{ route('branchlogin') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group">
                        <input type="email" id="email" name="email" placeholder="Enter your email address" required value="{{ old('email') }}">
                        <div class="input-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                    <div class="error-message" id="emailError"></div>
                    @error('email')
                        <div class="error-message" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        <div class="input-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="input-icon toggle-password" id="togglePassword">
                            <i class="fas fa-eye-slash"></i>
                        </div>
                    </div>
                    <div class="error-message" id="passwordError"></div>
                    @error('password')
                        <div class="error-message" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="remember-forgot">
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">Remember me</label>
                    </div>
                    <a href="#" class="forgot-password">Forgot Password?</a>
                </div>
                
                <button type="submit" class="login-button" id="loginButton">Login to Branch</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Toggle password visibility
            $('#togglePassword').click(function() {
                const passwordInput = $('#password');
                const icon = $(this).find('i');
                
                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                } else {
                    passwordInput.attr('type', 'password');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                }
            });
            
            // Form validation
            $('#branchLoginForm').on('submit', function(e) {
                // Reset errors
                $('.error-message').hide();
                $('#errorAlert').hide();
                
                // Get form values
                const email = $('#email').val().trim();
                const password = $('#password').val();
                
                // Simple validation
                let isValid = true;
                
                if (!email) {
                    $('#emailError').text('Email is required').show();
                    isValid = false;
                } else if (!isValidEmail(email)) {
                    $('#emailError').text('Please enter a valid email address').show();
                    isValid = false;
                }
                
                if (!password) {
                    $('#passwordError').text('Password is required').show();
                    isValid = false;
                }
                
                if (!isValid) {
                    e.preventDefault();
                    return;
                }
                
                // Change button text
                $('#loginButton').text('Logging in...').prop('disabled', true);
            });
            
            // Email validation function
            function isValidEmail(email) {
                const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(String(email).toLowerCase());
            }
            
            // Show error messages from server if any
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    toastr.error('{{ $error }}');
                @endforeach
            @endif
        });
    </script>
</body>
</html>