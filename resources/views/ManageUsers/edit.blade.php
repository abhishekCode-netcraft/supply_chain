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
          <h5 class="border-bottom pb-2 mb-3">Personal Information</h5>
          <div class="mb-2">
            <input type="text" name="name" value="{{ old('name',$user->name) }}"
              class="form-control" placeholder="Name" required>
          </div>
          <div class="mb-2">
            <input type="email" name="email" value="{{ old('email',$user->email) }}"
              class="form-control" placeholder="Email Address" required>
          </div>
          <div class="mb-2">
            <input type="text" name="mobile" value="{{ old('mobile',$user->mobile) }}"
              class="form-control" placeholder="Phone No." required>
          </div>
          <div class="mb-2">
            <input type="text" name="whatsapp" value="{{ old('whatsapp',$user->whatsapp_no) }}"
              class="form-control" placeholder="Whatsapp No.">
          </div>
          <div class="mb-2">
            <input type="text" name="alternate_no" value="{{ old('alternate_no',$user->alternate_no) }}"
              class="form-control" placeholder="Alternate No.">
          </div>

          {{-- Personal Document --}}
          <div class="mb-2">
            <label class="form-label">Upload Personal Document</label>
            <input type="file" name="personal_upload" class="form-control">
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
          <h5 class="border-bottom pb-2 mb-3">Business Information</h5>
          <div class="mb-2">
            <input type="text" name="business_name" value="{{ old('business_name',$user->business_name) }}"
              class="form-control" placeholder="Business Name" required>
          </div>
          <div class="mb-2">
            <textarea name="business_address" rows="3" class="form-control" placeholder="Business Address with Pin-Code" required>{{ old('business_address',$user->business_address) }}</textarea>
          </div>
          <div class="mb-2">
            <input type="email" name="business_email" value="{{ old('business_email',$user->business_email) }}"
              class="form-control" placeholder="Business Email">
          </div>
          <div class="mb-2">
            <input type="text" name="business_phone" value="{{ old('business_phone',$user->business_phone) }}"
              class="form-control" placeholder="Business Phone">
          </div>

          <div class="mb-2">
            <label class="form-label">Upload Business Document</label>
            <input type="file" name="business_upload" class="form-control">
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
        <div class="col-md-6">
          <label class="form-label">Unshipped Order Date (Numeric)</label>
          <input type="number"
            name="order_date"
            value="{{ old('order_date', $user->order_date) }}"
            class="form-control"
            placeholder="Enter Unshipped order date in numbers">
        </div>

        <div class="col-md-6">
          <label class="form-label">Under Process Order Date (Numeric)</label>
          <input type="number"
            name="underProcess_order_date"
            value="{{ old('underProcess_order_date', $user->underProcess_order_date) }}"
            class="form-control"
            placeholder="Enter Under Process order date in numbers">
        </div>
      </div>


      {{-- Security --}}
      <div class="mt-3">
        <h5 class="border-bottom pb-2 mb-3">Security</h5>
        <div class="mb-2">
          <input type="password" name="password" class="form-control"
            placeholder="(Leave blank to keep same)">
        </div>
        <div class="mb-2">
          <input type="password" name="password_confirmation" class="form-control"
            placeholder="Confirm Password">
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