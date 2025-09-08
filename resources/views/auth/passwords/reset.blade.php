@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')

<style>
    /*body {*/
    /*    min-height: 100vh;*/
    /*    margin: 0;*/
    /*    background: linear-gradient(135deg, #43cea2, #185a9d);*/
    /*    display: flex;*/
    /*    justify-content: center;*/
    /*    align-items: center;*/
    /*    overflow: hidden;*/
    /*    font-family: 'Segoe UI', sans-serif;*/
    /*}*/

    /* floating abstract circles */
    body::before, body::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        opacity: 0.6;
    }
    body::before {
        width: 300px;
        height: 300px;
        top: -100px;
        left: -80px;
        background: #6a11cb;
    }
    body::after {
        width: 250px;
        height: 250px;
        bottom: -80px;
        right: -70px;
        background: #11998e;
    }
    
     @media only screen and (min-width: 768px) {
        .reset-box {
            left: 20% !important;
        }
    }

    .reset-box {
        position: relative;
        width: 100%;
        max-width: 400px;
        background: #fff;
        border-radius: 16px;
        padding: 40px 30px;
        /*box-shadow: 0 8px 24px rgba(0,0,0,0.2);*/
        z-index: 2;
        animation: fadeIn 0.8s ease;
    }

    .reset-box h2 {
        text-align: center;
        margin-bottom: 25px;
        font-size: 1.8rem;
        font-weight: 700;
        color: #185a9d;
    }

    label {
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
        color: #333;
    }

    .form-control {
        width: 100%;
        border: 2px solid #e5e5e5;
        border-radius: 10px;
        padding: 10px 12px;
        font-size: 0.95rem;
        margin-bottom: 16px;
        transition: 0.3s;
    }

    .form-control:focus {
        border-color: #43cea2;
        box-shadow: 0 0 0 3px rgba(67,206,162,0.3);
        outline: none;
    }

    .btn-gradient {
        width: 100%;
        border: none;
        border-radius: 50px;
        padding: 12px;
        font-size: 1rem;
        font-weight: 600;
        color: #fff;
        background: linear-gradient(135deg, #43cea2, #6a11cb);
        transition: transform 0.2s, opacity 0.2s;
        cursor: pointer;
    }

    .btn-gradient:hover {
        transform: scale(1.03);
        opacity: 0.9;
    }

    .invalid-feedback {
        color: #d9534f;
        font-size: 0.85rem;
        margin-top: -10px;
        margin-bottom: 12px;
        display: block;
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(20px);}
        to {opacity: 1; transform: translateY(0);}
    }
</style>

<div class="reset-box">
    <h2>ðŸ”‘ Reset Password</h2>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <!-- Email -->
        <label for="email">Email Address</label>
        <input id="email" type="email"
               class="form-control @error('email') is-invalid @enderror"
               name="email"
               value="{{ $email ?? old('email') }}"
               placeholder="Enter your email"
               required autofocus>
        @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror

        <!-- Password -->
        <label for="password">New Password</label>
        <input id="password" type="password"
               class="form-control @error('password') is-invalid @enderror"
               name="password"
               placeholder="Enter new password"
               required>
        @error('password')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror

        <!-- Confirm Password -->
        <label for="password-confirm">Confirm New Password</label>
        <input id="password-confirm" type="password"
               class="form-control"
               name="password_confirmation"
               placeholder="Confirm new password"
               required>

        <!-- Submit -->
        <button type="submit" class="btn-gradient">
            Reset Password
        </button>
    </form>
</div>

@endsection
