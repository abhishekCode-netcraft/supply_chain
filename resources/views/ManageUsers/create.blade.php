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
          <div class="mb-2"><input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Name" required></div>
          <div class="mb-2"><input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email" required></div>
          <div class="mb-2"><input type="text" name="mobile" value="{{ old('mobile') }}" class="form-control" placeholder="Phone No." required></div>
          <div class="mb-2"><input type="text" name="whatsapp" value="{{ old('whatsapp') }}" class="form-control" placeholder="Whatsapp No."></div>
          <div class="mb-2"><input type="text" name="alternate_no" value="{{ old('alternate_no') }}" class="form-control" placeholder="Alternate No."></div>
          <div class="mb-2">
            <label class="form-label">Upload Personal Document</label>
            <input type="file" name="personal_upload" class="form-control">
          </div>
        </div>

        {{-- Business --}}
        <div class="col-md-6">
          <h5 class="border-bottom pb-2 mb-3">Business Information</h5>
          <div class="mb-2"><input type="text" name="business_name" value="{{ old('business_name') }}" class="form-control" placeholder="Business Name" required></div>
          <div class="mb-2">
            <textarea name="business_address" rows="3" class="form-control" placeholder="Business Address with Pin-Code" required>{{ old('business_address') }}</textarea>
          </div>
          <div class="mb-2"><input type="email" name="business_email" value="{{ old('business_email') }}" class="form-control" placeholder="Business Email"></div>
          <div class="mb-2"><input type="text" name="business_phone" value="{{ old('business_phone') }}" class="form-control" placeholder="Business Phone"></div>
          <div class="mb-2">
            <label class="form-label">Upload Business Document</label>
            <input type="file" name="business_upload" class="form-control">
          </div>
        </div>
      </div>

      {{-- Security --}}
      <div class="mt-3">
        <h5 class="border-bottom pb-2 mb-3">Security</h5>
        <div class="mb-2"><input type="password" name="password" class="form-control" placeholder="Password" required></div>
        <div class="mb-2"><input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required></div>
      </div>

      {{-- Admin controls --}}
      <div class="mt-3">

      </div>

      <div class="d-flex justify-content-between mt-3">
        <a href="{{ route('users.index') }}" class="btn btn-light">Back</a>
        <button class="btn btn-primary">Save</button>
      </div>
    </form>

  </div>
</div>

@endsection