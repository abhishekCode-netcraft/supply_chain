@extends('layouts.master')
@section('title', __("Edit User"))

@section('content')

<div class="card shadow-sm">
  <div class="card-body">

    <form method="POST" action="{{ route('users.update',$user->id) }}" enctype="multipart/form-data">
      @csrf @method('PUT')

      <h2 class="fw-bold mb-4">Edit User</h2>

      <div class="row">
        {{-- Personal --}}
        <div class="col-md-6">
          <h5 class="border-bottom pb-2 mb-3 fw-bold">Personal Information</h5>

          <div class="mb-2">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="{{ old('name',$user->name) }}"
              class="form-control @error('name') is-invalid @enderror" placeholder="Name" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-2">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" value="{{ old('email',$user->email) }}"
              class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" required>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-2">
            <label class="form-label">Phone No.</label>
            <input type="text" name="mobile" value="{{ old('mobile',$user->mobile) }}"
              class="form-control @error('mobile') is-invalid @enderror" placeholder="Phone No." required>
            @error('mobile') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-2">
            <label class="form-label">Whatsapp No.</label>
            <input type="text" name="whatsapp" value="{{ old('whatsapp',$user->whatsapp_no) }}"
              class="form-control @error('whatsapp') is-invalid @enderror" placeholder="Whatsapp No.">
            @error('whatsapp') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-2">
            <label class="form-label">Alternate No.</label>
            <input type="text" name="alternate_no" value="{{ old('alternate_no',$user->alternate_no) }}"
              class="form-control @error('alternate_no') is-invalid @enderror" placeholder="Alternate No.">
            @error('alternate_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          {{-- Personal Document --}}
          <div class="mb-2">
            <label class="form-label">Upload Personal Document</label>
            <input type="file" name="personal_upload" class="form-control @error('personal_upload') is-invalid @enderror">
            @error('personal_upload') <div class="invalid-feedback">{{ $message }}</div> @enderror

            @if($user->personal_upload)
            <div class="mt-2">
              <span class="small text-muted">Current:</span><br>
              <img src="{{ asset('storage/'.$user->personal_upload) }}"
                alt="Personal Document"
                class="img-thumbnail mt-1"
                style="max-height: 120px;">
            </div>
            @endif
          </div>
        </div>

        {{-- Business --}}
        <div class="col-md-6">
          <h5 class="border-bottom pb-2 mb-3 fw-bold">Business Information</h5>

          <div class="mb-2">
            <label class="form-label">Business Name</label>
            <input type="text" name="business_name" value="{{ old('business_name',$user->business_name) }}"
              class="form-control @error('business_name') is-invalid @enderror" placeholder="Business Name" required>
            @error('business_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-2">
            <label class="form-label">Business Address with Pin-Code</label>
            <textarea name="business_address" rows="3"
              class="form-control @error('business_address') is-invalid @enderror"
              placeholder="Business Address with Pin-Code" required>{{ old('business_address',$user->business_address) }}</textarea>
            @error('business_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-2">
            <label class="form-label">Business Email</label>
            <input type="email" name="business_email" value="{{ old('business_email',$user->business_email) }}"
              class="form-control @error('business_email') is-invalid @enderror" placeholder="Business Email">
            @error('business_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-2">
            <label class="form-label">Business Phone</label>
            <input type="text" name="business_phone" value="{{ old('business_phone',$user->business_phone) }}"
              class="form-control @error('business_phone') is-invalid @enderror" placeholder="Business Phone">
            @error('business_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-2">
            <label class="form-label">Upload Business Document</label>
            <input type="file" name="business_upload" class="form-control @error('business_upload') is-invalid @enderror">
            @error('business_upload') <div class="invalid-feedback">{{ $message }}</div> @enderror

            @if($user->business_upload)
            <div class="mt-2">
              <span class="small text-muted">Current:</span><br>
              <img src="{{ asset('storage/'.$user->business_upload) }}"
                alt="Business Document"
                class="img-thumbnail mt-1"
                style="max-height: 120px;">
            </div>
            @endif
          </div>
        </div>
      </div>

      {{-- Extra fields in one row --}}
      <div class="row mb-2 mt-3">
        <div class='col-md-6'>
          <div class='row'>
            <div class="col-md-6">
              <label class="form-label">Unshipped Order Date (Min)</label>
              <input type="number"
                name="order_date_min"
                value="{{ old('order_date_min', $user->order_date_min) }}"
                class="form-control"
                placeholder="Enter Unshipped order date in numbers">
            </div>

            <div class="col-md-6">
              <label class="form-label">Unshipped Order Date (Max)</label>
              <input type="number"
                name="order_date_max"
                value="{{ old('order_date_max', $user->order_date_max) }}"
                class="form-control"
                placeholder="Enter Unshipped order date in numbers">
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class='row'>
            <div class='col-md-6'>
              <label class="form-label">Under Process Order Date (Min)</label>
              <input type="number"
                name="underProcess_order_date_min"
                value="{{ old('underProcess_order_date_min', $user->underProcess_order_date_min) }}"
                class="form-control"
                placeholder="Enter Under Process order date in numbers">
            </div>

            <div class='col-md-6'>
              <label class="form-label">Under Process Order Date (Max)</label>
              <input type="number"
                name="underProcess_order_date_max"
                value="{{ old('underProcess_order_date_max', $user->underProcess_order_date_max) }}"
                class="form-control"
                placeholder="Enter Under Process order date in numbers">
            </div>
          </div>
        </div>
      </div>

  <div class="mt-3">
        <label class="form-label">{{ __('OTP Features') }}</label>
        <select class="form-control" name="otp_feature">
          <option value=1 {{ $user->otp_feature == 1 ? 'selected' : '' }}>On - Login Via OTP</option>
          <option value=0 {{ $user->otp_feature == 0 ? 'selected' : '' }}>Off - No OTP Required</option>
        </select>

        @error('otp_feature')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
      {{-- Security --}}
      <div class="mt-3">
        <h5 class="border-bottom pb-2 mb-3 fw-bold">Security</h5>

        <div class="mb-2">
          <label class="form-label">Password</label>
          <input type="password" name="password"
            class="form-control @error('password') is-invalid @enderror"
            placeholder="(Leave blank to keep same)">
          @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-2">
          <label class="form-label">Confirm Password</label>
          <input type="password" name="password_confirmation"
            class="form-control @error('password_confirmation') is-invalid @enderror"
            placeholder="Confirm Password">
          @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
      </div>

      <div class="d-flex justify-content-between mt-3">
        <a href="{{ route('users.index') }}" class="btn btn-light">Back</a>
        <button class="btn btn-primary">Update</button>
      </div>
    </form>

  </div>
</div>

@endsection