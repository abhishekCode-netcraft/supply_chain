@extends('layouts.master')

@section('title', __("Dashboard"))

@section('content')
<style>
    .card-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }
    
    @media only screen and (max-width: 600px) {
        .export-pdf {
            width:100%;
        }
        
        .search-bar {
            max-width:370px;
        }
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
        
        .search-bar {
            max-width:347px !important;
        }
    }

    @media only screen and (min-width: 992px) {
        .card-grid {
            grid-template-columns: repeat(4, 1fr);
        }
        
        .search-bar {
            max-width:68% !important;
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

    .tabs {
        background-color: #6c5ffc !important;
        color: white !important;
        font-size: 16px !important;
    }

    /* .tabs.active {
        border: 3px solid black !important;
    } */

     /* Common gradient style */
    .nav-tabs .nav-link {
        background: linear-gradient(135deg, #1e293b, #0f172a); /* dark gray â†’ almost black */
        color: #fff;
        border: none;
        border-radius: 8px;
        margin: 0 5px;
        transition: all 0.3s ease;
    }

    /* Active tab */
    .nav-tabs .nav-link.active {
        background: linear-gradient(135deg, #111827, #1e40af); /* black â†’ dark navy */
        color: #fff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
    }

    /* Hover effect */
    .nav-tabs .nav-link:hover {
        background: linear-gradient(135deg, #0f172a, #1e293b);
        color: #fff;
    }
    
    .search-bar {
        display: flex;
        align-items: center;
        max-width: 500px;
        width: 100%;
        background: rgba(20, 20, 40, 0.8); /* dark background */
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 18px;
        overflow: hidden;
        backdrop-filter: blur(6px);
    }

    .search-bar input {
        flex: 1;
        border: none;
        outline: none;
        padding: 12px 20px;
        font-size: 16px;
        background: transparent;
        color: #fff;
    }

    .search-bar input::placeholder {
        color: rgba(255, 255, 255, 0.6);
    }

    .search-bar button {
        border: none;
        padding: 12px 25px;
        font-size: 16px;
        font-weight: bold;
        color: #111;
        background: #cbd5e1;
        cursor: pointer;
        border-radius: 0 15px 15px 0;
        transition: 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .search-bar button:hover {
        background: #94a3b8;
    }
    
    .export-bar {
        display: flex;
        align-items: center;
        gap: 0;
        background: #1e293b; /* Dark container */
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        max-width: 500px;
    }

    .export-bar select {
        flex: 1;
        border: none;
        outline: none;
        padding: 12px 16px;
        font-size: 15px;
        background: #334155; /* slightly lighter than container */
        color: #f8fafc;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .export-bar select:hover {
        background: #475569;
    }

    .export-bar select option {
        color: #000; /* dropdown options visible */
    }

    .export-bar button {
        border: none;
        padding: 12px 24px;
        font-size: 15px;
        font-weight: 600;
        color: #fff;
        background: linear-gradient(135deg, #ef4444, #b91c1c);
        cursor: pointer;
        transition: all 0.3s ease;
        border-radius: 0; /* matches container */
        white-space: nowrap;
    }

    .export-bar button:hover {
        background: linear-gradient(135deg, #dc2626, #7f1d1d);
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.25);
    }

</style>

<div class="main-container container-fluid">
    <ul class="nav nav-tabs row g-0" id="orderTabs" role="tablist" style="margin-bottom:20px; border: none;">
        <li class="nav-item col-6 text-center">
            <button class="nav-link w-100 py-3 fs-5 fw-bold {{ $activeTab == 'unshipped' ? 'active' : '' }} tabs p-1 justify-content-center"
                id="unshipped-tab" data-bs-toggle="tab" data-bs-target="#unshipped" type="button" role="tab">
                Awaiting
            </button>
        </li>
        <li class="nav-item col-6 text-center">
            <button class="nav-link w-100 py-3 fs-5 fw-bold {{ $activeTab == 'underprocess' ? 'active' : '' }} tabs p-1 justify-content-center"
                id="underprocess-tab" data-bs-toggle="tab" data-bs-target="#underprocess" type="button" role="tab">
                Processing
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
                        <form method="GET" class="search-bar">
                            <input type="hidden" name="tab" value="unshipped">
                            <input type="text" 
                                   name="search_unshipped" 
                                   placeholder="Search by Publisher / Book Name"
                                   value="{{ $searchUnshipped }}">
                            <button type="submit">
                                Search 
                            </button>
                        </form>
                        <!--<form method="GET" class="d-flex flex-grow-1" style="max-width: 500px;">-->
                        <!--    <input type="hidden" name="tab" value="unshipped">-->
                        <!--    <input type="text"-->
                        <!--        name="search_unshipped"-->
                        <!--        class="form-control form-control-lg me-2"-->
                        <!--        placeholder="Search Item..."-->
                        <!--        value="{{ $searchUnshipped }}">-->
                        <!--    <button class="btn btn-primary btn-lg px-5 w-50" type="submit">Search</button>-->
                        <!--</form>-->

                        <form method="GET" action="{{ route('dashboard.exportPdf') }}" class="export-bar">
                            <input type="hidden" name="tab" value="unshipped">
                            <input type="hidden" name="search_unshipped" value="{{ $searchUnshipped }}">
                            <input type="hidden" name="unshipped_page" value="{{ request('unshipped_page', 1) }}">
                        
                            <select name="export_type">
                                <option value="with_image">With Images</option>
                                <option value="without_image">Without Images</option>
                            </select>
                        
                            <button type="submit">ðŸ“„ Export PDF</button>
                        </form>
                    </div>
                </div>

            </div>

            <div class="card-grid">
                @forelse($unshipped as $item)
                <div class="card h-auto shadow-sm border-0 mb-2">
                    <div class="position-relative">
                        <a href="javascript:void(0)" class="open-image" data-src="{{ $item->clean_thumb }}">
                            <!--<img src="{{ $item->clean_thumb }}" class="card-img-top img-fluid rounded-top" alt="Image">-->
                            <img src="{{ $item->clean_thumb }}" 
                                 class="card-img-top img-fluid rounded-top" 
                                 alt="Image"
                                 onerror="this.onerror=null;this.src='/dummy.jpg';">
                                 
                            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                                {{ $item->order_count }}
                            </span>
                        </a>
                    </div>
                    <div class="card-body text-center p-2">
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

            <div class="d-flex justify-content-center my-4">
                {{ $unshipped->appends(request()->except('unshipped_page'))->links() }}
            </div>
        </div>

        {{-- Under Process --}}
        <div class="tab-pane fade {{ $activeTab == 'underprocess' ? 'show active' : '' }}" id="underprocess" role="tabpanel">
            <div class="row mb-3 align-items-center">
                <div class="col-6"></div>
                <div class="col-12 mb-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <!--<form method="GET" class="d-flex flex-grow-1" style="max-width: 500px;">-->
                        <!--    <input type="hidden" name="tab" value="underprocess">-->
                        <!--    <input type="text"-->
                        <!--        name="search_underprocess"-->
                        <!--        class="form-control form-control-lg me-2"-->
                        <!--        placeholder="Search Under Process..."-->
                        <!--        value="{{ $searchUnderprocess }}">-->
                        <!--    <button class="btn btn-primary btn-lg px-5 w-50" type="submit">Search</button>-->
                        <!--</form>-->
                        
                        <form method="GET" class="search-bar">
                            <input type="hidden" name="tab" value="underprocess">
                            <input type="text" 
                                   name="search_underprocess" 
                                   placeholder="Search by Publisher / Book Name"
                                   value="{{ $searchUnderprocess }}">
                            <button type="submit">
                                Search 
                            </button>
                        </form>
                        
                        <!--<form method="GET" action="{{ route('dashboard.exportPdf') }}" class="d-flex align-items-center gap-1 export-pdf">-->
                        <!--    <input type="hidden" name="tab" value="underprocess">-->
                        <!--    <input type="hidden" name="search_underprocess" value="{{ $searchUnderprocess }}">-->
                        <!--    <input type="hidden" name="underprocess_page" value="{{ request()->get('underprocess_page', 1) }}">-->

                        <!--    <select name="export_type" class="form-select me-2 h-25" style="min-width: 160px;">-->
                        <!--        <option value="with_image">With Images</option>-->
                        <!--        <option value="without_image">Without Images</option>-->
                        <!--    </select>-->

                        <!--    <button class="btn btn-danger btn-lg px-4" type="submit" style="min-width: 180px;">-->
                        <!--        Export to PDF-->
                        <!--    </button>-->
                        <!--</form>-->
                        
                        <form method="GET" action="{{ route('dashboard.exportPdf') }}" class="export-bar">
                            <input type="hidden" name="tab" value="underprocess">
                            <input type="hidden" name="search_underprocess" value="{{ $searchUnderprocess }}">
                            <input type="hidden" name="underprocess_page" value="{{ request()->get('underprocess_page', 1) }}">
                        
                            <select name="export_type">
                                <option value="with_image">With Images</option>
                                <option value="without_image">Without Images</option>
                            </select>
                        
                            <button type="submit">ðŸ“„ Export PDF</button>
                        </form>
                    </div>
                </div>

            </div>

            <div class="card-grid">
                @forelse($underProcess as $item)
                <div class="card h-auto shadow-sm border-0">
                    <div class="position-relative">
                        <a href="javascript:void(0)" class="open-image" data-src="{{ $item->clean_thumb }}">
                            <img src="{{ $item->clean_thumb }}" 
                                 class="card-img-top img-fluid rounded-top" 
                                 alt="Image"
                                 onerror="this.onerror=null;this.src='/dummy.jpg';">

                            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                                {{ $item->order_count }}
                            </span>
                        </a>
                    </div>
                    <div class="card-body text-center  p-2">
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

            <div class="d-flex justify-content-center my-4">
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