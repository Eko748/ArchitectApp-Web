@foreach ($data as $item)
@foreach ($item->hasil as $key)
@php
$img[] = $key->softfile;
@endphp
@endforeach
<div class="col-lg-3 col-md-6 col-sm mb-3">
    <div class="card border-0 projectCard">
        @if ($item->hasil_count == 0)
        <img src="{{ asset('img/progress.gif') }}" class="card-img-top" alt="..." style="max-height: 150">
        
        @else
        <img src="{{ asset('img/file hasil/image/' . $img[0]) }}" class="card-img-top" alt="..."
        style="max-height: 150">
        
        @endif
        <div class="card-body">
            <h5 class="card-title">{{ $item->project->title }}</h5>
            <p class="card-text desc">{{ $item->project->description }}</p>
            <div class="d-grid gap-1">
                
                <a href="{{ route('owner.detil.myproject', $item->id) }}"
                    class="btn btn-warning btn-sm btn-block">Lihat Detail
                </a>
                
            </div>
            
        </div>
    </div>
</div>
@endforeach
