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
    <form action="{{ route('profile.update') }}" method="POST" enctype='multipart/form-data'>
        @csrf

        <div class="row">
            <div class="col-md-9 col-xl-9">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title">
                            {{ __('Profile update') }}
                        </h4>

                        <button type="submit" class="btn btn-primary float-right">Save</button>
                    </div>

                    <div class="card-body">
                        <div>
                            <div class="form-group">
                                <label for="name" class="form-label">{{ __('Name') }}<span class="text-danger">*</span></label>
                                <input id="name" {{ auth()->user()->account_details_change_limitations ? 'disabled' : '' }} type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $user->name }}" autocomplete="name" autofocus placeholder="Admin">

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">{{ __('Email') }}<span class="text-danger">*</span></label>
                                <input id="email" disabled type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $user->email }}" autocomplete="email" placeholder="Email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="mobile" class="form-label">{{ __('Mobile') }}<span class="text-danger">*</span></label>
                                <input id="mobile" {{ auth()->user()->account_details_change_limitations ? 'disabled' : '' }} type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') ?? $user->mobile }}" autocomplete="mobile" placeholder="Mobile">

                                @error('mobile')
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
                            <label for="current_password" class="form-label">{{ __('Current Password') }}<span class="text-danger">*</span></label>
                            <input id="current_password" {{ auth()->user()->account_details_change_limitations ? 'disabled' : '' }} type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" autocomplete="current_password" placeholder="Current Password">

                            @error('current_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">{{ __('New Password') }}<span class="text-danger">*</span></label>
                            <input id="password" {{ auth()->user()->account_details_change_limitations ? 'disabled' : '' }} type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password" placeholder="Confirm Password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">{{ __('Confirm New Password') }}<span class="text-danger">*</span></label>
                            <input id="password_confirmation" {{ auth()->user()->account_details_change_limitations ? 'disabled' : '' }} type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" autocomplete="new-password" placeholder="Confirm Password">

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
                                        <input type="file" class="dropify @error('images') is-invalid @enderror" data-default-file="{{ $user->profile }}" data-bs-height="180" id="profile" name="profile" />
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