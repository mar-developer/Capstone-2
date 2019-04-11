@extends('layouts.app')

@section('title')
Cart
@endsection

@section('content')
<div class="container">
    @if(session()->has('message'))
    <div class="alert alert-danger">
        {{ session()->get('message') }}
    </div>
@endif

 @if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif


    <h1 class="text-center mb-5 title">Cart Items</h1>

    <table class="table table-dark table-striped table-des">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Item Name</th>
                <th>Price</th>
                <th>Return Date</th>
                <th>Duration</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php
            $counter = 0;
            $total = 0;
            @endphp

            @forelse ($user->items as $item)
            <tr>
                <td>{{ ++$counter }}</td>
                <td><img class="img-fluid" style="height:150px; width:150px; object-fit:contain" src="{{ asset("images/games/$item->img_path") }}" alt="{{ $item->img_path }}"></td>
                <td><span style="line-height:80px">{{ $item->name }}</span>
                    <hr>
                    <span>No. of copies to borrow:  {{  $count = \App\item_user::where('user_id', Auth::user()->id)->where('items_id', $item->id)->count() }}</span>
                </td>
                <td>&#8369; {{ $item->price }}/day</td>
                <td><input class="form-control mb-2" value="{{ $item->pivot->duration }}" readonly>
                    <div class="panel-group" id="accordion">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne{{ $item->id }}" class="btn btn-light col-md-12 btn-outline-info">
                                    Change Date
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne{{ $item->id }}" class="panel-collapse collapse in">
                            <div class="panel-body">

                                <form method="post" action="/edit_date/{{ $item->id }}" name="form">
                                    @csrf
                                    @method('put')
                                    <input class="form-control" id="edit_date" type="date" value="{{ $item->pivot->duration }}" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" max="{{ Carbon\Carbon::now()->addMonth(8)->format('Y-m-d') }}" name="date">
                                    <button class="btn btn-primary float-right mt-2">Update</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </td>
                @php
                $now = Carbon\Carbon::today();
                $today = Carbon\Carbon::parse($now)->format('Y-m-d');
                $end  = Carbon\Carbon::parse($item->pivot->duration);

                $duration = $end->diffInDays($today);
                @endphp

                <td>{{ $duration }} days</td>
                <td>&#8369; {{ $item->price * $duration }}</td>

                @php
                $total += $item->price * $duration;
                @endphp
                <td>
                    <form method="post" action="/delete_cart_item/{{ $item->id }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">No item to show</td>
            </tr>
            @endforelse
            <tr>
                <td colspan="6">Total</td>
                <td colspan="2">&#8369; {{ $total }}</td>
            </tr>

        </tbody>
    </table>
    @if(Auth::user()->status == 'pending')
    <button class="btn btn-danger float-right disabled">Account is still pending</button>

    @elseif(!empty($item))
        <form method="post" action="/transaction/{{ Auth::user()->id }}">
            @csrf
            <button class="btn btn-primary float-right">Proceed to Checkout</button>
        </form>
    @else
            <button class="btn btn-primary float-right disabled">Proceed to Checkout</button>

    @endif

</div>
@endsection
