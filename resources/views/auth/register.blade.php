@extends('layouts.app')

@section('title', 'Register')

@section('content')
<form method="POST" action="{{ route('register.store') }}" enctype="multipart/form-data">
    @csrf

    <h2 class="text-center mb-5 fw-bold">Register</h2>

    <div class="row">
        {{-- PERSONAL INFORMATION --}}
        <div class="col-md-6">
            <h4 class="fw-bold border-bottom pb-2 mb-4">Personal Information</h4>

            <div class="mb-3">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                    name="name" value="{{ old('name') }}" placeholder="Name" required autofocus>
                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" placeholder="Email" required>
                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror"
                    name="mobile" value="{{ old('mobile') }}" placeholder="Phone No." required>
                @error('mobile') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <input id="whatsapp" type="text" class="form-control @error('whatsapp') is-invalid @enderror"
                    name="whatsapp" value="{{ old('whatsapp') }}" placeholder="Whatsapp No.">
                @error('whatsapp') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <input id="alternate_no" type="text" class="form-control @error('alternate_no') is-invalid @enderror"
                    name="alternate_no" value="{{ old('alternate_no') }}" placeholder="Alternate No.">
                @error('alternate_no') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Personal Document</label>
                <input type="file" class="form-control @error('personal_upload') is-invalid @enderror"
                    name="personal_upload">
                @error('personal_upload') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>

        {{-- BUSINESS INFORMATION --}}
        <div class="col-md-6">
            <h4 class="fw-bold border-bottom pb-2 mb-4">Business Information</h4>

            <div class="mb-3">
                <input id="business_name" type="text" class="form-control @error('business_name') is-invalid @enderror"
                    name="business_name" value="{{ old('business_name') }}" placeholder="Business Name" required>
                @error('business_name') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <textarea id="business_address" class="form-control @error('business_address') is-invalid @enderror"
                    name="business_address" placeholder="Business Address with Pin-Code" rows="3" required>{{ old('business_address') }}</textarea>
                @error('business_address') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <input id="business_email" type="email" class="form-control @error('business_email') is-invalid @enderror"
                    name="business_email" value="{{ old('business_email') }}" placeholder="Business Email">
                @error('business_email') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <input id="business_phone" type="text" class="form-control @error('business_phone') is-invalid @enderror"
                    name="business_phone" value="{{ old('business_phone') }}" placeholder="Business Phone">
                @error('business_phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Business Document</label>
                <input type="file" class="form-control @error('business_upload') is-invalid @enderror"
                    name="business_upload">
                @error('business_upload') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>

    {{-- SECURITY --}}
    <div class="mt-4">
        <h4 class="fw-bold border-bottom pb-2 mb-4">Security</h4>

        <div class="mb-3">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                name="password" placeholder="Password" required>
            @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <input id="password-confirm" type="password" class="form-control"
                name="password_confirmation" placeholder="Confirm Password" required>
        </div>
    </div>

    {{-- Account status default inactive --}}
    <input type="hidden" name="is_active" value="0">

    <div class="d-flex justify-content-between align-items-center mt-4">
        <a href="{{ route('login') }}" class="text-primary">Back to Login</a>
        <button type="submit" class="btn btn-primary px-4">Register</button>
    </div>
</form>
@endsection
