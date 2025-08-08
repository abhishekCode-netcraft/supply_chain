@extends('layouts.master')

@section('title', __('Profile Update'))

@section('content')

<!-- CONTAINER -->
<div class="main-container container-fluid">
    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">{{ __('Profile Update') }}</h1>

        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">{{ __('Profile') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Profile Update') }}</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- Row -->
    <form action="" method="POST" enctype='multipart/form-data'>
        @csrf

        <div class="row">
            <div class="col-md-9 col-xl-9">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title">
                            {{ __('Profile update') }}
                        </h4>

                        <!-- <button type="submit" class="btn btn-primary float-right">Save</button> -->
                    </div>

                    <div class="card-body">
                        <div>
                            <div class="form-group">
                                <label for="name" class="form-label">{{ __('Name') }}<span class="text-danger">*</span></label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $user->name }}" autocomplete="name" autofocus placeholder="Admin" readonly>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">{{ __('Email') }}<span class="text-danger">*</span></label>
                                <input id="email" disabled type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $user->email }}" autocomplete="email" placeholder="Email" readonly>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="mobile" class="form-label">{{ __('Mobile') }}<span class="text-danger">*</span></label>
                                <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') ?? $user->mobile }}" autocomplete="mobile" placeholder="Mobile" readonly>

                                @error('mobile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="father_name" class="form-label">{{ __('Father\'s Name') }}<span class="text-danger">*</span></label>
                                <input id="father_name" type="text" class="form-control @error('father_name') is-invalid @enderror" name="father_name" value="{{ old('father_name') ?? $user->father_name }}" autocomplete="father_name" placeholder="Father Name" readonly>

                                @error('father_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="mother_name" class="form-label">{{ __('Mother\'s Name') }}<span class="text-danger">*</span></label>
                                <input id="mother_name" type="text" class="form-control @error('mother_name') is-invalid @enderror" name="mother_name" value="{{ old('mother_name') ?? $user->mother_name }}" autocomplete="mother_name" placeholder="Mother Name" readonly>

                                @error('mother_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">

                        <div class="form-group">
                            <label for="account_type" class="form-label">{{ __('Account Type') }}<span class="text-danger">*</span></label>

                            <select class="form-control" disabled name="account_type">
                                <option value="1" {{ $user->account_type = 1 ? 'selected' : '' }}>Individual</option>
                                <option value="2" {{ $user->account_type = 2 ? 'selected' : '' }}>Retailer</option>
                                <option value="3" {{ $user->account_type = 3 ? 'selected' : '' }}>Publisher</option>
                                <option value="4" {{ $user->account_type = 4 ? 'selected' : '' }}>Wholesaler</option>
                            </select>

                            @error('account_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="aadhaar_no" class="form-label">{{ __('Aadhaar Number') }}<span class="text-danger">*</span></label>
                            <input id="aadhaar_no" type="text" class="form-control @error('aadhaar_no') is-invalid @enderror" name="aadhaar_no" value="{{ old('aadhaar_no') ?? $user->aadhaar_no }}" autocomplete="aadhaar_no" placeholder="Adhaar No." readonly>

                            @error('aadhaar_no')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="state" class="form-label">{{ __('State') }}<span class="text-danger">*</span></label>
                            <input id="state" type="text" class="form-control @error('state') is-invalid @enderror" name="state" value="{{ old('state') ?? $user->state }}" autocomplete="state" placeholder="State" readonly>

                            @error('state')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="pincode" class="form-label">{{ __('Pincode') }}<span class="text-danger">*</span></label>
                            <input id="pincode" type="text" class="form-control @error('pincode') is-invalid @enderror" name="pincode" value="{{ old('pincode') ?? $user->pincode }}" autocomplete="pincode" placeholder="Pincode" readonly>

                            @error('pincode')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="full_address" class="form-label">{{ __('Full Address') }}<span class="text-danger">*</span></label>
                            <textarea id="full_address" class="form-control @error('full_address') is-invalid @enderror" name="full_address" autocomplete="full_address" placeholder="Full Address" readonly>{{ old('full_address') ?? $user->full_address }}</textarea>

                            @error('full_address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="current_password" class="form-label">{{ __('Current Password') }}<span class="text-danger">*</span></label>
                            <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" autocomplete="current_password" placeholder="Current Password" readonly>

                            @error('current_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">{{ __('New Password') }}<span class="text-danger">*</span></label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password" placeholder="Confirm Password" readonly>

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">{{ __('Confirm New Password') }}<span class="text-danger">*</span></label>
                            <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" autocomplete="new-password" placeholder="Confirm Password" readonly>

                            @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">

                    <div class="card-body">
                        <div class="form-group">
                            <div id="fileInputContainer">
                                <div class="form-group">
                                    <label for="fileInput1">Profile Image<span class="text-danger">*</span></label>

                                    <div class="form-group mb-0" @error('profile') style="border: red 2px dotted;" @enderror>
                                        <input type="file" class="dropify @error('images') is-invalid @enderror" data-default-file="{{ $user->profile }}" data-bs-height="180" id="profile" name="profile" readonly />
                                    </div>

                                    @error('images')
                                    <span class="invalid-feedback mt-2" style="display:block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="card-body">
                        Date - {{date('d-m-Y')}}
                        <div class="form-group">
                            <div class="d-flex mb-4 mt-3 align-items-center">
                                <div class="avatar avatar-md bg-secondary-transparent text-secondary bradius me-3">
                                    <i class="fe fe-check"></i>
                                </div>
                                <div class="">
                                    <h6 class="mb-1 fw-semibold">Approved Listings</h6>
                                </div>
                                <div class=" ms-auto my-auto">
                                    <p class="fw-bold fs-20 m-0">{{$userCounts->approved_count??0}}</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="avatar  avatar-md bg-pink-transparent text-pink bradius me-3">
                                    <i class="fe fe-x"></i>
                                </div>
                                <div class="">
                                    <h6 class="mb-1 fw-semibold">Rejected Listings</h6>
                                </div>
                                <div class=" ms-auto my-auto">
                                    <p class="fw-bold fs-20 mb-0">{{$userCounts->reject_count??0}}</p>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </form>
</div>
<!-- End Row -->
</div>
@endsection

@push('js')
<script src="{{ asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
<script src="{{ asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
<!-- INTERNAL File-Uploads Js-->
<script src="{{ asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
<script src="{{ asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
<script src="{{ asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
@endpush