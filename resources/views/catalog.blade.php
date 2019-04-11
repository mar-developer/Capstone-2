@extends('layouts.app')

@section('title')
Catalog
@endsection

@section('content')
<div class="container">
    <h1 class="text-center mb-3 title" >Games Rental Shop</h1>

    @php
    $items= \App\items::all()
    @endphp

    @forelse ($items as $item)
    <div class="col-md-4 float-left mb-4">
        <div class="card p-2">
            <img class="card-img-top mt-3" style="width:auto; height:250px ; object-fit:contain;" src="{{ asset("images/games/$item->img_path") }}" alt="Card Image">
            <div class="card-body">
                <h5 class="card-title mb-4 text-center" style="height: 4px">{{ $item->name }}</h5>
            </div>
            <div class="panel-group" id="accordion">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne{{ $item->id }}" class="btn btn-light col-md-10 ml-4 btn-outline-info">
                            Description
                        </a>
                    </h4>
                </div>
                <div id="collapseOne{{ $item->id }}" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <div class="card-body">
                                <p class="card-text">{{ $item->description }}</p>
                            <p class="card-text mt-2">Category: {{ $item->category }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-transparent">
                <span style="margin-left:10px" class="text-nowrap d-block">Price: &#8369; {{ $item->price }}/day</span>
                <span style="margin-left:10px" class="text-nowrap">No. of available copies: {{  $count = \App\serials::where('items_id', $item->id)->where('status','available')->count() }}</span>
                <span style="margin-left:10px" class="text-nowrap">No. of copies that can be borrowed: 3</span>
                    <hr>
                    <form action="/add_cart/{{ Auth::user()->id }}/{{ $item->id }}" method="post">
                    @csrf
                    <label for="duration">Return Date:</label>
                    <input id="duration" class="form-control mb-2" type="date" name="duration" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" max="{{ Carbon\Carbon::now()->addMonth(8)->format('Y-m-d') }}" required>
                    @php
                    $barrowed_count = \App\transactions::where('users_id', Auth::user()->id)->where('items_id', $item->id)->count();
                    $item_count = \App\serials::where('items_id', $item->id)->where('status','available')->count();
                    @endphp
                    <button class="btn btn-primary btn-block mt-2 add-to-cart"
                    @if ($barrowed_count == 3)
                    disabled data-toggle="tooltip" title="You already reached barrowed limit" data-placement="top"
                    @elseif($count == 0)
                    disabled data-toggle="tooltip" title="No available copies" data-placement="top"
                    @endif
                    >Add to cart</button>
                </form>
            </div>
        </div>
    </div>
@empty
<div class="alert alert-secondary text-center" role="alert">
    Nothing to show
</div>

@endforelse

@endsection
