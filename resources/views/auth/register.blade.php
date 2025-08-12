@extends('layouts.app')

@section('title', 'Register')

@section('content')
<form method="POST" action="{{ route('register.store') }}" enctype="multipart/form-data">
    @csrf

    <span class="login100-form-title pb-5">Register</span>

    {{-- PERSONAL INFORMATION --}}
    <h5 class="mb-3">Personal Information</h5>
    <div class="wrap-input100 validate-input input-group">
        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
            name="name" value="{{ old('name') }}" placeholder="Name" required autofocus>
        @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
    </div>

    <div class="wrap-input100 validate-input input-group">
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
            name="email" value="{{ old('email') }}" placeholder="Email" required>
        @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
    </div>

    <div class="wrap-input100 validate-input input-group">
        <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror"
            name="mobile" value="{{ old('mobile') }}" placeholder="Phone No." required>
        @error('mobile') <span class="invalid-feedback">{{ $message }}</span> @enderror
    </div>

    <div class="wrap-input100 validate-input input-group">
        <input id="whatsapp" type="text" class="form-control @error('whatsapp') is-invalid @enderror"
            name="whatsapp" value="{{ old('whatsapp') }}" placeholder="Whatsapp No.">
        @error('whatsapp') <span class="invalid-feedback">{{ $message }}</span> @enderror
    </div>
    <div class="wrap-input100 validate-input input-group">
        <input id="alternate_no" type="text" class="form-control @error('alternate_no') is-invalid @enderror"
            name="alternate_no" value="{{ old('alternate_no') }}" placeholder="Alternate No.">
        @error('alternate_no') <span class="invalid-feedback">{{ $message }}</span> @enderror
    </div>

    <div class="wrap-input100 validate-input input-group">
        <label class="mt-2">Upload Personal Document</label>
        <input type="file" class="form-control @error('personal_upload') is-invalid @enderror"
            name="personal_upload">
        @error('personal_upload') <span class="invalid-feedback">{{ $message }}</span> @enderror
    </div>

    {{-- BUSINESS INFORMATION --}}
    <h5 class="mt-4 mb-3">Business Information</h5>


    <div class="wrap-input100 validate-input input-group">
        <input id="business_name" type="text" class="form-control @error('business_name') is-invalid @enderror"
            name="business_name" value="{{ old('business_name') }}" placeholder="Business Name" required>
        @error('business_name') <span class="invalid-feedback">{{ $message }}</span> @enderror
    </div>

    <div class="wrap-input100 validate-input input-group">
        <textarea id="business_address" class="form-control @error('business_address') is-invalid @enderror"
            name="business_address" placeholder="Business Address with Pin-Code" required>{{ old('business_address') }}</textarea>
        @error('business_address') <span class="invalid-feedback">{{ $message }}</span> @enderror
    </div>

    <div class="wrap-input100 validate-input input-group">
        <input id="business_email" type="email" class="form-control @error('business_email') is-invalid @enderror"
            name="business_email" value="{{ old('business_email') }}" placeholder="Business Email">
        @error('business_email') <span class="invalid-feedback">{{ $message }}</span> @enderror
    </div>

    <div class="wrap-input100 validate-input input-group">
        <input id="business_phone" type="text" class="form-control @error('business_phone') is-invalid @enderror"
            name="business_phone" value="{{ old('business_phone') }}" placeholder="Business Phone">
        @error('business_phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
    </div>

    <div class="wrap-input100 validate-input input-group">
        <label class="mt-2">Upload Business Document</label>
        <input type="file" class="form-control @error('business_upload') is-invalid @enderror"
            name="business_upload">
        @error('business_upload') <span class="invalid-feedback">{{ $message }}</span> @enderror
    </div>

    {{-- SECURITY --}}
    <h5 class="mt-4 mb-3">Security</h5>
    <div class="wrap-input100 validate-input input-group">
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
            name="password" placeholder="Password" required>
        @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
    </div>

    <div class="wrap-input100 validate-input input-group">
        <input id="password-confirm" type="password" class="form-control"
            name="password_confirmation" placeholder="Confirm Password" required>
    </div>

    {{-- Account status default inactive --}}
    <input type="hidden" name="is_active" value="0">

    <p class="mb-0">
        <a href="{{ route('login') }}" class="text-primary ms-1">Back to Login</a>
    </p>
    <div class="container-login100-form-btn">
        <button type="submit" class="login100-form-btn btn-primary">Register</button>
    </div>
</form>
@endsection