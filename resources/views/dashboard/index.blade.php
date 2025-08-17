@extends('layouts.master')

@section('title', __("Dashboard"))

@section('content')
<style>
    .card-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    @media only screen and (min-width: 600px) {
        .card-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media only screen and (min-width: 768px) {
        .card-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media only screen and (min-width: 992px) {
        .card-grid {
            grid-template-columns: repeat(4, 1fr);

        }
    }


    @media only screen and (min-width: 1200px) {
        .card-grid {
            grid-template-columns: repeat(5, 1fr);
        }
    }


    .card-title {
        font-size: 0.95rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease-in-out;
    }
</style>

<div class="main-container container-fluid">

    {{-- Tabs --}}
    <ul class="nav nav-tabs row g-0" id="orderTabs" role="tablist" style="margin-bottom:20px;">
        <li class="nav-item col-6 text-center">
            <button class="nav-link w-100 py-3 fs-5 fw-bold {{ $activeTab == 'unshipped' ? 'active' : '' }}"
                id="unshipped-tab" data-bs-toggle="tab" data-bs-target="#unshipped" type="button" role="tab">
                Unshipped Items
            </button>
        </li>
        <li class="nav-item col-6 text-center">
            <button class="nav-link w-100 py-3 fs-5 fw-bold {{ $activeTab == 'underprocess' ? 'active' : '' }}"
                id="underprocess-tab" data-bs-toggle="tab" data-bs-target="#underprocess" type="button" role="tab">
                Under Process Items
            </button>
        </li>
    </ul>

    <div class="tab-content" id="orderTabsContent">

        {{-- Unshipped --}}
        <div class="tab-pane fade {{ $activeTab == 'unshipped' ? 'show active' : '' }}" id="unshipped" role="tabpanel">

            <div class="row mb-3 align-items-center">
                <div class="col-6"></div>
                <div class="col-12 mb-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">


                        <form method="GET" class="d-flex flex-grow-1" style="max-width: 500px;">
                            <input type="hidden" name="tab" value="unshipped">
                            <input type="text"
                                name="search_unshipped"
                                class="form-control form-control-lg me-2"
                                placeholder="Search Unshipped..."
                                value="{{ $searchUnshipped }}">
                            <button class="btn btn-primary btn-lg" type="submit">Search</button>
                        </form>

                        <form method="GET" action="{{ route('dashboard.exportPdf') }}" class="d-flex align-items-center">
                            <input type="hidden" name="tab" value="unshipped">
                            <input type="hidden" name="search_unshipped" value="{{ $searchUnshipped }}">
                            <input type="hidden" name="unshipped_page" value="{{ request('unshipped_page', 1) }}">

                            <select name="export_type" class="form-select me-2">
                                <option value="with_image">With Images</option>
                                <option value="without_image">Without Images</option>
                            </select>

                            <button class="btn btn-danger btn-lg px-4" type="submit" style="min-width: 180px;">
                                Export to PDF
                            </button>
                        </form>


                    </div>
                </div>

            </div>

            <div class="card-grid">
                @forelse($unshipped as $item)
                <div class="card h-100 shadow-sm border-0">
                    <div class="position-relative">
                        <a href="{{ $item->clean_thumb }}" target="_blank">
                            <img src="{{ $item->clean_thumb }}" class="card-img-top img-fluid rounded-top" alt="Image">
                            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                                {{ $item->order_count }}
                            </span>
                        </a>
                    </div>
                    <div class="card-body text-center">
                        <h6 class="card-title mb-0" title="{{ $item->title }}">{{ $item->title }}</h6>
                    </div>
                </div>
                @empty
                <p>No unshipped items found.</p>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $unshipped->appends(request()->except('unshipped_page'))->links() }}
            </div>
        </div>

        {{-- Under Process --}}
        <div class="tab-pane fade {{ $activeTab == 'underprocess' ? 'show active' : '' }}" id="underprocess" role="tabpanel">

            <div class="row mb-3 align-items-center">
                <div class="col-6"></div>
                <div class="col-12 mb-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">


                        <form method="GET" class="d-flex flex-grow-1" style="max-width: 500px;">
                            <input type="hidden" name="tab" value="underprocess">
                            <input type="text"
                                name="search_underprocess"
                                class="form-control form-control-lg me-2"
                                placeholder="Search Under Process..."
                                value="{{ $searchUnderprocess }}">
                            <button class="btn btn-primary btn-lg" type="submit">Search</button>
                        </form>


                        <form method="GET" action="{{ route('dashboard.exportPdf') }}" class="d-flex align-items-center">
                            <input type="hidden" name="tab" value="underprocess">
                            <input type="hidden" name="search_underprocess" value="{{ $searchUnderprocess }}">
                            <input type="hidden" name="underprocess_page" value="{{ request()->get('underprocess_page', 1) }}">

                            <select name="export_type" class="form-select me-2" style="min-width: 160px;">
                                <option value="with_image">With Images</option>
                                <option value="without_image">Without Images</option>
                            </select>

                            <button class="btn btn-danger btn-lg px-4" type="submit" style="min-width: 180px;">
                                Export to PDF
                            </button>
                        </form>

                    </div>
                </div>

            </div>

            <div class="card-grid">
                @forelse($underProcess as $item)
                <div class="card h-100 shadow-sm border-0">
                    <div class="position-relative">
                        <a href="{{ $item->clean_thumb }}" target="_blank">
                            <img src="{{ $item->clean_thumb }}" class="card-img-top img-fluid rounded-top" alt="Image">
                            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                                {{ $item->order_count }}
                            </span>
                        </a>
                    </div>
                    <div class="card-body text-center">
                        <h6 class="card-title mb-0" title="{{ $item->title }}">{{ $item->title }}</h6>
                    </div>
                </div>
                @empty
                <p>No under process items found.</p>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $underProcess->appends(request()->except('underprocess_page'))->links() }}
            </div>
        </div>

    </div>
</div>
@endsection