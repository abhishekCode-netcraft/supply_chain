@extends('layouts.master')

@section('title', __("Dashboard"))

@section('content')

<!-- CONTAINER -->
<div class="main-container container-fluid">
    <!-- PAGE-HEADER -->
    <div class="page-header m-0">
        <div class="page-header m-0">
            <h1 class="page-title">{{ __('Your Sessions') }}</h1>
        </div>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Dashboard') }}</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@push('js')

@endpush