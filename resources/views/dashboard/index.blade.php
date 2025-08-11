@extends('layouts.master')

@section('title', __("Dashboard"))

@section('content')
<div class="main-container container-fluid">

    <ul class="nav nav-tabs row g-0" id="orderTabs" role="tablist" style="margin-bottom:20px;">
        <li class="nav-item col-6 text-center">
            <button class="nav-link active w-100 py-3 fs-5 fw-bold" id="unshipped-tab"
                data-bs-toggle="tab" data-bs-target="#unshipped" type="button" role="tab"
                aria-controls="unshipped" aria-selected="true">
                Unshipped Items
            </button>
        </li>
        <li class="nav-item col-6 text-center">
            <button class="nav-link w-100 py-3 fs-5 fw-bold" id="underprocess-tab"
                data-bs-toggle="tab" data-bs-target="#underprocess" type="button" role="tab"
                aria-controls="underprocess" aria-selected="false">
                Under Process Items
            </button>
        </li>
    </ul>

    <div class="tab-content" id="orderTabsContent">

        {{-- Unshipped Items --}}
        <div class="tab-pane fade show active" id="unshipped" role="tabpanel" aria-labelledby="unshipped-tab">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered align-middle">
                    <thead class="table-primary text-center fw-bold fs-5">
                        <tr>
                            <th>Sl. No</th>
                            <th>Image</th>
                            <th>Title</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $count = ($unshipped->currentPage() - 1) * $unshipped->perPage() + 1; @endphp
                        @foreach($unshipped as $item)
                        <tr>
                            <td class="text-center">{{ $count++ }}</td>
                            <td class="text-center position-relative">
                                <a href="{{ $item->clean_thumb }}" target="_blank">
                                    <img src="{{ $item->clean_thumb }}" alt="Image" class="img-fluid rounded" style="max-width:80px;">
                                    <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                                        {{ $item->order_count }}
                                    </span>
                                </a>
                            </td>

                            <td>{{ $item->title }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $unshipped->links() }}
            </div>
        </div>

        {{-- Under Process Items --}}
        <div class="tab-pane fade" id="underprocess" role="tabpanel" aria-labelledby="underprocess-tab">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered align-middle">
                    <thead class="table-primary text-center fw-bold fs-5">
                        <tr>
                            <th>Sl. No</th>
                            <th>Image</th>
                            <th>Title</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $count = ($underProcess->currentPage() - 1) * $underProcess->perPage() + 1; @endphp
                        @foreach($underProcess as $item)
                        <tr>
                            <td class="text-center">{{ $count++ }}</td>
                            <td class="text-center position-relative">
                                <a href="{{ $item->clean_thumb }}" target="_blank">
                                    <img src="{{ $item->clean_thumb }}" alt="Image" class="img-fluid rounded" style="max-width:80px;">
                                    <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                                        {{ $item->order_count }}
                                    </span>
                                </a>
                            </td>
                            <td>{{ $item->title }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $underProcess->links() }}
            </div>
        </div>

    </div>
</div>
@endsection