@extends('layouts.master')

@section('title', __("Dashboard"))

@push('css')
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
                max-width:50% !important;
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
@endpush

@section('content')

<div class="main-container container-fluid">
    @php
        // Default active tab
        $activeTab = $activeTab ?? null;

        // If user does not have "Awaiting" permission but has "Processing"
        if (!auth()->user()->can('Dashboard -> Awaiting') && auth()->user()->can('Dashboard -> Processing')) {
            $activeTab = 'underprocess';
        }
    @endphp

    <ul class="nav nav-tabs row g-0" id="orderTabs" role="tablist" style="margin-bottom:20px; border: none;">
        @can('Dashboard -> Awaiting')
            <li class="nav-item col-6 text-center">
                <button class="nav-link w-100 py-3 fs-5 fw-bold {{ $activeTab == 'unshipped' ? 'active' : '' }} tabs p-1 justify-content-center"
                    id="unshipped-tab" data-bs-toggle="tab" data-bs-target="#unshipped" type="button" role="tab">
                    Awaiting
                </button>
            </li>
        @endcan

        @can('Dashboard -> Processing')
            <li class="nav-item col-6 text-center">
                <button class="nav-link w-100 py-3 fs-5 fw-bold {{ $activeTab == 'underprocess' ? 'active' : '' }} tabs p-1 justify-content-center"
                    id="underprocess-tab" data-bs-toggle="tab" data-bs-target="#underprocess" type="button" role="tab">
                    Processing
                </button>
            </li>
        @endcan
    </ul>

    <div class="tab-content" id="orderTabsContent">
        <div class="tab-pane fade {{ $activeTab == 'unshipped' ? 'show active' : '' }}" id="unshipped" role="tabpanel">
            @include('dashboard.filters', ['name' => 'search_unshipped', 'tab' => 'unshipped', 'page' => 'unshipped_page'])

            <div class="card-grid">
                @can('Dashboard -> Awaiting')
                @include('dashboard.books-listing', ['data' => $unshipped])
                @endcan
            </div>
        </div>

        {{-- Under Process --}}
        <div class="tab-pane fade {{ $activeTab == 'underprocess' ? 'show active' : '' }}" id="underprocess" role="tabpanel">
            @include('dashboard.filters', ['name' => 'search_underprocess', 'tab' => 'underprocess', 'page' => 'underprocess_page'])

            <div class="card-grid">
                @can('Dashboard -> Processing')
                @include('dashboard.books-listing', ['data' => $underProcess])
                @endcan
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