@extends('layouts.master')

@section('title', __("Add User"))
@section('content')
<div class="card shadow-sm">
  <div class="card-body">

    <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
      @csrf
      <h2 class="fw-bold mb-4">Add User</h2>

      <div class="row">
        {{-- Personal --}}
        <div class="col-md-6">
          <h5 class="border-bottom pb-2 mb-3">Personal Information</h5>

          <div class="mb-2">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Name" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-2">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Email" required>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-2">
            <label class="form-label">Phone No.</label>
            <input type="text" name="mobile" value="{{ old('mobile') }}" class="form-control @error('mobile') is-invalid @enderror" placeholder="Phone No." required>
            @error('mobile') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-2">
            <label class="form-label">Whatsapp No.</label>
            <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" class="form-control @error('whatsapp') is-invalid @enderror" placeholder="Whatsapp No.">
            @error('whatsapp') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-2">
            <label class="form-label">Alternate No.</label>
            <input type="text" name="alternate_no" value="{{ old('alternate_no') }}" class="form-control @error('alternate_no') is-invalid @enderror" placeholder="Alternate No.">
            @error('alternate_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-2">
            <label class="form-label">Upload Personal Document</label>
            <input type="file" name="personal_upload" class="form-control @error('personal_upload') is-invalid @enderror">
            @error('personal_upload') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
        </div>

        {{-- Business --}}
        <div class="col-md-6">
          <h5 class="border-bottom pb-2 mb-3">Business Information</h5>

          <div class="mb-2">
            <label class="form-label">Business Name</label>
            <input type="text" name="business_name" value="{{ old('business_name') }}" class="form-control @error('business_name') is-invalid @enderror" placeholder="Business Name" required>
            @error('business_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-2">
            <label class="form-label">Business Address with Pin-Code</label>
            <textarea name="business_address" rows="3" class="form-control @error('business_address') is-invalid @enderror" placeholder="Business Address with Pin-Code" required>{{ old('business_address') }}</textarea>
            @error('business_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-2">
            <label class="form-label">Business Email</label>
            <input type="email" name="business_email" value="{{ old('business_email') }}" class="form-control @error('business_email') is-invalid @enderror" placeholder="Business Email">
            @error('business_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-2">
            <label class="form-label">Business Phone</label>
            <input type="text" name="business_phone" value="{{ old('business_phone') }}" class="form-control @error('business_phone') is-invalid @enderror" placeholder="Business Phone">
            @error('business_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-2">
            <label class="form-label">Upload Business Document</label>
            <input type="file" name="business_upload" class="form-control @error('business_upload') is-invalid @enderror">
            @error('business_upload') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
        </div>
      </div>

      {{-- Security --}}
      <div class="mt-3">
        <h5 class="border-bottom pb-2 mb-3">Security</h5>

        <div class="mb-2">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
          @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-2">
          <label class="form-label">Confirm Password</label>
          <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password" required>
          @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
      </div>

      {{-- Admin controls --}}
      <div class="mt-3"></div>

      <div class="d-flex justify-content-between mt-3">
        <a href="{{ route('users.index') }}" class="btn btn-light">Back</a>
        <button class="btn btn-primary">Save</button>
      </div>
    </form>

  </div>
</div>
@endsection
