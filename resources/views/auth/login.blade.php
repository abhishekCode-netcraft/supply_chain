@extends('layouts.app')

@section('title', 'Login')

@section('content')

<style>
    body {
        background: #f8f9fc;
        overflow-x: hidden;
    }

    /* Gradient box wrapper */
    .login-form {
        max-width: 500px;
        margin: 50px auto;
        padding: 2px; /* border effect */
        border-radius: 14px;
        background: linear-gradient(135deg, #0d6efd, #6f42c1);
        box-shadow: 0px 6px 16px rgba(0, 0, 0, 0.12);
    }

    /* Inner white box */
    .login-form .form-inner {
        background: #ffffff;
        border-radius: 12px;
        padding: 26px 30px;
    }

    .login-form h2 {
        font-weight: 700;
        font-size: 1.7rem;
    }

    .form-control {
        padding: 11px 15px;
        font-size: 1rem;
        border-radius: 8px;
        border: 1px solid #ced4da;
        transition: all 0.2s;
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.25);
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
    }

    .btn-primary {
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        padding: 10px 22px;
        background: linear-gradient(135deg, #0d6efd, #6f42c1);
        border: none;
    }

    .btn-primary:hover {
        opacity: 0.9;
    }

    .invalid-feedback {
        font-size: 0.9rem;
    }

    /* Medium screen fix */
    @media (max-height: 800px) {
        .login-form .form-inner {
            padding: 18px 22px;
        }
        .btn-primary {
            padding: 8px 18px;
            font-size: 0.95rem;
        }
    }

    /* Mobile adjustments */
    @media (max-width: 767px) {
        .login-form {
            margin: 12px;
        }
        .login-form .form-inner {
            padding: 16px 18px;
        }
        .login-form h2 {
            font-size: 1.5rem;
        }
    }
</style>

<div class="login-form">
    <div class="form-inner">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <h2 class="text-center mb-4 text-primary">Login Now</h2>
            
            @if(session('success'))
            <div class="alert alert-primary" role="alert">
                {{ session('success') }}
            </div>
            @endif
            @if(session('expire_error'))
            <div class="alert alert-danger" role="alert">
                {{ session('expire_error') }}
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger" role="alert">
                {!! session('error') !!}
            </div>
            @endif

            <div class="mb-3">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" placeholder="Email Address" required autofocus>
                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" placeholder="Enter Password" required>
                @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                <label class="form-check-label" for="remember">Remember Me</label>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('password.request') }}" class="text-decoration-none text-primary">Forgot Password?</a>
                <button type="submit" class="btn btn-primary">Login</button>
            </div>

            <div class="text-center mt-3">
                <span>Don’t have an account? </span>
                <a href="{{ route('register') }}" class="text-decoration-none text-primary">Register</a>
            </div>
        </form>
    </div>
</div>
@endsection
