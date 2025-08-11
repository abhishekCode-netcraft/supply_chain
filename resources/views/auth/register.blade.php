@extends('layouts.app')

@section('title', 'Register')

@section('content')
<form method="POST" action="{{ route('register.store') }}">
        @csrf

    <span class="login100-form-title pb-5">Register</span>
    
    <div class="wrap-input100 validate-input input-group">
        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
            name="name" value="{{ old('name') }}" placeholder="Name" required autofocus>
        @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="wrap-input100 validate-input input-group">
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
            name="email" value="{{ old('email') }}" placeholder="Email" required>
        @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="wrap-input100 validate-input input-group">
        <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror"
            name="mobile" value="{{ old('mobile') }}" placeholder="Mobile" required>
        @error('mobile')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="wrap-input100 validate-input input-group">
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
            name="password" placeholder="Password" required>
        @error('password')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="wrap-input100 validate-input input-group">
        <input id="password-confirm" type="password" class="form-control"
            name="password_confirmation" placeholder="Confirm Password" required>
    </div>

    <input type="hidden" name="status" value="1"> {{-- Default Active Status --}}

    <p class="mb-0">
        <a href="{{ route('login') }}" class="text-primary ms-1">Back to Login</a>
    </p>
    <div class="container-login100-form-btn">
        <button type="submit" class="login100-form-btn btn-primary">Register</button>
    </div>
</form>
@endsection
