@extends('matrimony.layouts.app')

@section('title', 'Matrimony Login')

@section('style')
    <style>
        .login-container {
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

        .desp p {
            font-size: 14px;
            font-weight: 500;
            color: #666;
        } 

        .form {
            margin-top: 25px;
        }

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

        .input-group input {
            width: 100%;
            padding: 5px 12px;
            border: 1px solid #ccc;
            font-size: 12px;
            font-weight: 600;
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

        .login {
            font-size: 13px;
            font-weight: 500;
        }

        @media (max-width: 991px) {

            .left {
                display: none;
            }

            .right {
                padding: 20px;
                width: 100%;
            }

            .login-form {
                max-width: 100%;
            }
        }
    </style>
@endsection

@section('content')
    <div class="login-container">
        <div class="container d-flex">
            <div class="left"></div>
            <div class="right">
                <div class="login-form">
                    <h3>Find Your Perfect Match</h3>
                    <p class="desp">Join India's most trusted matrimonial platform</p> 
                    
                    <form class="form" method="POST" action="{{ route('matrimony.login') }}">
                        @csrf
                        <div class="input-group">
                            <input type="email" placeholder="Email" name="email" required value="{{ old('email') }}">
                        </div>
                    
                        <div class="input-group">
                            <input type="password" placeholder="Password" name="password" required>
                        </div>
                    
                        <button type="submit" class="login-btn">Submit</button>

                        <p class="terms">By clicking on Register Free, you agree to the <a href="#">Terms & Conditions</a>.</p>
                        <p class="login">Don't have an account?<a href="/matrimony/register">Sign Up</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection