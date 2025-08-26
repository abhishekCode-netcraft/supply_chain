@forelse($data as $item)
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

<div class="d-flex justify-content-center my-4">
    {{ $data->appends(request()->except('unshipped_page'))->links() }}
</div>