@extends('layouts.app')

@section('title', 'Register')

@section('content')

<style>
    body {
        background: #f8f9fc;
        overflow-x: hidden;
    }

    /* Gradient box wrapper */
    .register-form {
        max-width: 950px;
        margin: 20px auto;
        padding: 2px; /* border effect */
        border-radius: 14px;
        background: linear-gradient(135deg, #0d6efd, #6f42c1);
        box-shadow: 0px 6px 16px rgba(0, 0, 0, 0.12);
    }

    /* Inner white box for contrast */
    .register-form .form-inner {
        background: #ffffff;
        border-radius: 12px;
        padding: 26px 30px;
    }

    .register-form h2 {
        font-weight: 700;
        font-size: 1.7rem;
    }

    .form-section h4 {
        font-size: 1.05rem;
        font-weight: 600;
        margin-bottom: 18px;
        color: #333;
        border-bottom: 1px solid #e9ecef;
        padding-bottom: 6px;
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

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
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

    /* Medium screen fix (like 1366x768) */
    @media (max-height: 800px) {
        .register-form .form-inner {
            padding: 18px 22px;
        }
        .form-section h4 {
            font-size: 1rem;
            margin-bottom: 14px;
        }
        .btn-primary {
            padding: 8px 18px;
            font-size: 0.95rem;
        }
    }

    /* Mobile adjustments */
    @media (max-width: 767px) {
        .register-form {
            margin: 12px;
        }
        .register-form .form-inner {
            padding: 16px 18px;
        }
        .register-form h2 {
            font-size: 1.5rem;
        }
        .form-section h4 {
            font-size: 0.95rem;
        }
    }
</style>

<div class="register-form">
    <div class="form-inner">
        <form method="POST" action="{{ route('register.store') }}" enctype="multipart/form-data">
            @csrf

            <h2 class="text-center mb-4 text-primary">Create Your Account</h2>

            <div class="row">
                {{-- PERSONAL INFORMATION --}}
                <div class="col-md-6 form-section">
                    <h4>Personal Information</h4>

                    <div class="mb-3">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" placeholder="Full Name" required autofocus>
                        @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" placeholder="Email Address" required>
                        @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror"
                            name="mobile" value="{{ old('mobile') }}" placeholder="Phone Number" required>
                        @error('mobile') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <input id="whatsapp" type="text" class="form-control @error('whatsapp') is-invalid @enderror"
                            name="whatsapp" value="{{ old('whatsapp') }}" placeholder="WhatsApp Number">
                        @error('whatsapp') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <input id="alternate_no" type="text" class="form-control @error('alternate_no') is-invalid @enderror"
                            name="alternate_no" value="{{ old('alternate_no') }}" placeholder="Alternate Number">
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
                <div class="col-md-6 form-section">
                    <h4>Business Information</h4>

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
            <div class="form-section mt-4">
                <h4>Security</h4>

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
                <a href="{{ route('login') }}" class="text-decoration-none text-primary">← Back to Login</a>
                <button type="submit" class="btn btn-primary">Register</button>
            </div>
        </form>
    </div>
</div>
@endsection