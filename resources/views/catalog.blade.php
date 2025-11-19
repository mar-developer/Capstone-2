@extends('layouts.app')

@section('title')
Catalog
@endsection

@section('content')
<div class="container">
    <h1 class="text-center mb-4 title">Games Rental Shop</h1>

    @php
    $items= \App\items::all()
    @endphp

    <div class="row">
    @forelse ($items as $item)
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-img-wrapper" style="height: 250px; overflow: hidden; background-color: #f8f9fa;">
                <img class="card-img-top"
                     style="width: 100%; height: 100%; object-fit: cover;"
                     src="{{ asset("images/games/$item->img_path") }}"
                     alt="{{ $item->name }}"
                     onerror="this.src='{{ asset("images/games/borderland.jpg") }}'">
            </div>
            <div class="card-body d-flex flex-column">
                <h5 class="card-title text-center mb-3" style="min-height: 48px; line-height: 1.2;">{{ $item->name }}</h5>

                <div class="accordion mb-3" id="accordion{{ $item->id }}">
                    <div class="card border-0">
                        <div class="card-header p-0 bg-white border-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseOne{{ $item->id }}" aria-expanded="false">
                                <i class="fas fa-info-circle"></i> Description
                            </button>
                        </div>
                        <div id="collapseOne{{ $item->id }}" class="collapse" data-parent="#accordion{{ $item->id }}">
                            <div class="card-body pt-0">
                                <p class="card-text small">{{ $item->description }}</p>
                                <p class="card-text small mb-0"><strong>Category:</strong> {{ $item->category }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-auto">
                    <div class="mb-2">
                        <small class="d-block"><strong>Price:</strong> &#8369; {{ $item->price }}/day</small>
                        <small class="d-block"><strong>Available:</strong> {{  $count = \App\serials::where('items_id', $item->id)->where('status','available')->count() }} copies</small>
                        <small class="d-block"><strong>Borrow Limit:</strong> 3 copies</small>
                    </div>

                    <form action="/add_cart/{{ Auth::user()->id }}/{{ $item->id }}" method="post" class="page-link-form">
                        @csrf
                        <div class="form-group">
                            <label for="duration{{ $item->id }}" class="small"><strong>Return Date:</strong></label>
                            <input id="duration{{ $item->id }}" class="form-control form-control-sm" type="date" name="duration" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" max="{{ Carbon\Carbon::now()->addMonth(8)->format('Y-m-d') }}" required>
                        </div>
                        @php
                        $barrowed_count = \App\transactions::where('users_id', Auth::user()->id)->where('items_id', $item->id)->count();
                        $item_count = \App\serials::where('items_id', $item->id)->where('status','available')->count();
                        @endphp
                        <button type="submit" class="btn btn-primary btn-block add-to-cart"
                        @if ($barrowed_count == 3)
                        disabled data-toggle="tooltip" title="You already reached borrow limit" data-placement="top"
                        @elseif($count == 0)
                        disabled data-toggle="tooltip" title="No available copies" data-placement="top"
                        @endif
                        >
                            <i class="fas fa-cart-plus"></i> Add to Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-12">
        <div class="alert alert-secondary text-center" role="alert">
            <i class="fas fa-inbox"></i> No games available at the moment
        </div>
    </div>
@endforelse
    </div>
</div>

<style>
.card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.15) !important;
}

.card-img-wrapper img {
    transition: transform 0.3s;
}

.card:hover .card-img-wrapper img {
    transform: scale(1.05);
}
</style>

@endsection
