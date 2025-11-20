@forelse($data as $item)
<div class="card h-auto shadow-sm border-0 mb-2">
    <div class="position-relative">
        <a href="javascript:void(0)" class="open-image" data-src="{{ $item->clean_thumb }}">
            <img src="{{ $item->clean_thumb }}"
                class="card-img-top img-fluid rounded-top"
                alt="Image"
                onerror="this.onerror=null;this.src='/dummy.jpg';"
                style='max-height:300px;'>

            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle"
                data-bs-toggle="tooltip"
                data-bs-html="true"
                >
                {{ $item->order_count }}
            </span>
        </a>
        
        
        @can('Dashboard -> Order Date')
        <div class='d-flex justify-content-between align-items-center mt-2 flex-wrap' style='grid-gap:5px;grid-gap:5px;background-color: #f9f964;color: black;padding: 10px;'>
            <div></div>
            <div>
                @foreach($item->order_dates as $ms)
                    <span>{{ \Carbon\Carbon::createFromTimestampMs((int)$ms)->format('d-m-Y') }}@if(!$loop->last),@endif</span>
                @endforeach
                @php 
                    $status = app('App\Models\OrdersExtraPayment')
                            ->where('order_id', $item->order_id)
                            ->first();
                    
                    if ($status) {
                        if ($status != 'pending') {
                            $icon = '<i class="fa fa-check-circle" style="font-size: 20px;color: green;"></i>';
                        } else {
                            $icon = '<i class="fa fa-times-circle" style="font-size: 20px;color: red;"></i>';
                        }
                    } else {
                        $icon = '<i class="fa fa-times-circle" style="font-size: 20px;color: red;"></i>';
                    }
                @endphp
                {!! $icon !!}
            </div>
            
            <a href="{{ route('download.image', ['url' => $item->clean_thumb]) }}"  class="me-2 d-flex justify-content-end">
                <i class="fa fa-download mt-2"></i>
            </a>
        </div>
        @endcan
    </div>
    <div class="card-body text-center p-2">
        <h6 class="card-title mb-0" >
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

