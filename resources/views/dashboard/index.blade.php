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
    }

    .short-title {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
        max-width: 100%;
    }

    .read-more {
        color: blue;
        cursor: pointer;
        font-size: 0.85rem;
        margin-left: 5px;
    }

    .image-modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        justify-content: center;
        align-items: center;
    }

    .image-modal img {
        max-width: 95%;
        max-height: 90%;
        border-radius: 8px;
    }

    .image-modal .close-btn {
        position: absolute;
        top: 15px;
        right: 25px;
        font-size: 30px;
        color: white;
        cursor: pointer;
        font-weight: bold;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease-in-out;
    }
</style>

<div class="main-container container-fluid">
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
                        <a href="javascript:void(0)" class="open-image" data-src="{{ $item->clean_thumb }}">

                            <img src="{{ $item->clean_thumb }}" class="card-img-top img-fluid rounded-top" alt="Image">
                            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                                {{ $item->order_count }}
                            </span>
                        </a>
                    </div>
                    <div class="card-body text-center">
                        <h6 class="card-title mb-0">
                            <span class="short-title">{{ \Illuminate\Support\Str::limit($item->title, 40) }}</span>
                            <span class="full-title d-none">{{ $item->title }}</span>
                            @if(strlen($item->title) > 40)
                            <span class="read-more">Read more</span>
                            @endif
                        </h6>
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
                        <a href="javascript:void(0)" class="open-image" data-src="{{ $item->clean_thumb }}">

                            <img src="{{ $item->clean_thumb }}" class="card-img-top img-fluid rounded-top" alt="Image">
                            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                                {{ $item->order_count }}
                            </span>
                        </a>
                    </div>
                    <div class="card-body text-center">
                        <h6 class="card-title mb-0">
                            <span class="short-title">{{ \Illuminate\Support\Str::limit($item->title, 40) }}</span>
                            <span class="full-title d-none">{{ $item->title }}</span>
                            @if(strlen($item->title) > 40)
                            <span class="read-more">Read more</span>
                            @endif
                        </h6>
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

<div class="image-modal" id="imageModal">
    <span class="close-btn">&times;</span>
    <img id="modalImage" src="" alt="Preview">
</div>

@endsection
@push('js')

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.read-more').forEach(btn => {
            btn.addEventListener('click', function() {
                const cardTitle = this.closest('.card-title');
                const shortTitle = cardTitle.querySelector('.short-title');
                const fullTitle = cardTitle.querySelector('.full-title');

                if (shortTitle.classList.contains('d-none')) {
                    shortTitle.classList.remove('d-none');
                    fullTitle.classList.add('d-none');
                    this.textContent = "Read more";
                } else {
                    shortTitle.classList.add('d-none');
                    fullTitle.classList.remove('d-none');
                    this.textContent = "Read less";
                }
            });
        });


        const modal = document.getElementById("imageModal");
        const modalImg = document.getElementById("modalImage");
        const closeBtn = modal.querySelector(".close-btn");

        document.querySelectorAll(".open-image").forEach(imgLink => {
            imgLink.addEventListener("click", function() {
                modal.style.display = "flex";
                modalImg.src = this.dataset.src;
            });
        });

        closeBtn.addEventListener("click", function() {
            modal.style.display = "none";
        });

        modal.addEventListener("click", function(e) {
            if (e.target === modal) {
                modal.style.display = "none";
            }
        });
    });
</script>
@endpush