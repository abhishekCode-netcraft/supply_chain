@extends('layouts.app')

@section('title', 'Auth')
@section('content')
<form method="POST" action="@if(isset($register) && $register){{ route('register.store') }}@else{{route('login')}}@endif">
    @csrf

    @if(isset($register) && $register)
    <input type="hidden" name="name" value="{{ request()->name }}" />
    <input type="hidden" name="email" value="{{ request()->email }}" />
    <input type="hidden" name="mobile" value="{{ request()->mobile }}" />
    <input type="hidden" name="allow_sessions" value="{{ request()->allow_sessions }}" />
    <input type="hidden" name="password" value="{{ request()->password }}" />
    <input type="hidden" name="plain_password" value="{{ request()->plain_password }}" />
    <input type="hidden" name="account_type" value="{{ request()->account_type }}" />
    <input type="hidden" name="aadhaar_no" value="{{ request()->aadhaar_no }}" />
    <input type="hidden" name="father_name" value="{{ request()->father_name }}" />
    <input type="hidden" name="mother_name" value="{{ request()->mother_name }}" />
    <input type="hidden" name="state" value="{{ request()->state }}" />
    <input type="hidden" name="pincode" value="{{ request()->pincode }}" />
    <input type="hidden" name="full_address" value="{{ request()->full_address }}" />
    @endif
    <span class="login100-form-title pb-5">
        Enter OTP
    </span>
    <div class="panel panel-primary">
        <div class="panel-body tabs-menu-body p-0 pt-2">
            <div class="tab-content">
                <div class="tab-pane active" id="tab5">
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    <input type="hidden" value="{{ request()->email }}" name="email" />
                    <input type="hidden" value="{{ request()->password }}" name="password" />
                    <input type="hidden" value=1 name="otp_feature" />

                    <div class="wrap-input100 validate-input input-group is-invalid">
                        <input type="text" class="form-control" name="otp" placeholder="Enter OTP...." autocomplete="email" autofocus>
                    </div>

                    <div class="row mb-5">
                        <div class="col-6">
                            <p class="mb-0"><a href="{{ route('login') }}" style="cursor: pointer;" class="text-primary ms-1">Back to Login</a>
                            </p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="mb-0"><a onclick="location.reload();" style="cursor: pointer;" class="text-primary ms-1">Regenerate OTP</a>
                            </p>
                        </div>
                    </div>

                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn btn-primary @if(isset($register) && !$register) validate @endif">
                            Validate
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.validate').click(function(e) {
            e.preventDefault();

            $.ajax({
                type: "POST",
                url: "{{ route('verify.otp') }}",
                data: {
                    otp: $('#otp').val(),
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },

                success: function(result) {
                    console.log(result);
                },
                error: function(error) {
                    alert(JSON.parse(error.responseText).message);
                }
            });
        });
    })
</script>
@endpush