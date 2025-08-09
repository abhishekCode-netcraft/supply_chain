@extends('layouts.app')

@section('title', 'Login')

@section('content')
<form method="GET" action="{{ route('register.otp') }}">
    <span class="login100-form-title pb-5">Register</span>
    <div class="panel panel-primary">
        <div class="panel-body tabs-menu-body p-0 pt-2">
            <div class="tab-content">
                <div class="tab-pane active" id="tab5">
                    <div style="display: grid;grid-template-columns: auto auto auto;grid-gap: 10px;align-items: center;">
                        <div class="wrap-input100 validate-input input-group is-invalid">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" autocomplete="name" autofocus placeholder="Name">

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="wrap-input100 validate-input input-group" id="Password-toggle">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" autocomplete="email" placeholder="Email">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="wrap-input100 validate-input input-group">
                            <input id="mobile" type="number" class="form-control @error('mobile') is-invalid @enderror"
                                name="mobile" value="{{ old('mobile') }}" autocomplete="mobile" autofocus placeholder="Mobile">
                            @error('mobile')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div style="display: grid;grid-template-columns: auto auto;grid-gap: 10px;align-items: center;">
                        <!-- <input type="hidden" name="plain_password" /> -->
                        <input type="hidden" name="allow_sessions" value="1" />
                        <div class="wrap-input100 validate-input input-group" id="Password-toggle">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                autocomplete="new-password" placeholder="Password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="wrap-input100 validate-input input-group" id="Password-toggle">
                            <input id="password-confirm" type="password" class="form-control" name="plain_password"
                                autocomplete="new-password" placeholder="Confirm Password">
                        </div>
                    </div>

                    <div style="display: grid;grid-template-columns: auto auto;grid-gap: 10px;align-items: center;">
                        <div class="wrap-input100 validate-input input-group">
                            <select class="form-control" name="account_type">
                                <option value="">Select Account Type</option>
                                <option value=1>Individual</option>
                                <option value=2>Retailer</option>
                                <option value=3>Publisher</option>
                                <option value=4>Wholesaler</option>
                            </select>

                            @error('account_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="wrap-input100 validate-input input-group">
                            <input id="aadhaar_no" type="number" class="form-control @error('aadhaar_no') is-invalid @enderror"
                                name="aadhaar_no" value="{{ old('aadhaar_no') }}" autocomplete="aadhaar_no" autofocus
                                placeholder="Aadhaar No">
                            @error('aadhaar_no')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div style="display: grid;grid-template-columns: auto auto;grid-gap: 10px;align-items: center;">
                        <div class="wrap-input100 validate-input input-group">
                            <input id="father_name" type="text"
                                class="form-control @error('father_name') is-invalid @enderror" name="father_name"
                                value="{{ old('father_name') }}" autocomplete="father_name" autofocus placeholder="Father Name">
                            @error('father_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="wrap-input100 validate-input input-group">
                            <input id="mother_name" type="text"
                                class="form-control @error('mother_name') is-invalid @enderror" name="mother_name"
                                value="{{ old('mother_name') }}" autocomplete="mother_name" autofocus placeholder="Mother Name">
                            @error('mother_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div style="display: grid;grid-template-columns: auto auto;grid-gap: 10px;align-items: center;">
                        <div class="wrap-input100 validate-input input-group">
                            <input id="state" type="text" class="form-control @error('state') is-invalid @enderror"
                                name="state" value="{{ old('state') }}" autocomplete="state" autofocus placeholder="State">
                            @error('state')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
    
                        <div class="wrap-input100 validate-input input-group">
                            <input id="pincode" type="number" class="form-control @error('pincode') is-invalid @enderror"
                                name="pincode" value="{{ old('pincode') }}" autocomplete="pincode" autofocus
                                placeholder="Pincode">
                            @error('pincode')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="wrap-input100 validate-input input-group">
                        <textarea class="form-control" name="full_address" cols="10" rows="5"
                            placeholder="Full Address"></textarea>
                        @error('full_address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- End Additional Fields -->
                </div>
                <p class="mb-0"><a href="{{ route('login') }}" class="text-primary ms-1">Back to Login</a></p>
                <div class="container-login100-form-btn">
                    <button type="submit" class="login100-form-btn btn-primary">Register</button>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection