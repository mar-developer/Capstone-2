@extends('layouts.app')

@section('title')
Transactions
@endsection

@section('content')
<div class="container">


    <h1 class="text-center mb-5 title">Transactions</h1>



    <table class="table table-dark table-striped table-des">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Image</th>
                <th id="trans-link">@sortablelink('Item Name')</th>
                {{-- <th id="trans-link">@sortablelink('transaction_code', 'Transaction code')</th> --}}
                <th id="trans-link">@sortablelink('price', 'Price')</th>
                <th id="trans-link">@sortablelink('rent_date', 'Rent Date')</th>
                <th id="trans-link">@sortablelink('return_date', 'Return Date')</th>
                <th id="text-nowrap">@sortablelink('duration', 'Duration')</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php
            $counter = 0;
            $total = 0;
            @endphp

            {{-- @forelse ($items as $item) --}}
            @forelse ($transactions as $transaction)
            @if ($transaction->users_id == Auth::user()->id)
            <tr>
                <td>{{ ++$counter }}</td>
                <td><img class="img-fluid" style="height:150px; width:150px; object-fit:contain" src="{{ asset("images/games/$transaction->img_path") }}" alt="{{ $transaction->img_path }}"></td>
                <td><span>{{ $transaction->name }}</span>
                    <hr>
                    <span>Transaction code</span>
                    <input class="form-control" value="{{ $transaction->transaction_code }}">
                    <hr>
                    <span>Item Status:
                    <span
                        @if ($transaction->status == "approved")
                        class="btn btn-success ml-4 mt-1"
                        @elseif($transaction->status == "rejected")
                        class="btn btn-danger ml-4 mt-1"
                        @elseif($transaction->status == "returned")
                        class="btn btn-dark ml-4 mt-1"
                        @elseif($transaction->status == "pending")
                        class="btn btn-warning ml-4 mt-1"
                        @endif >{{ $transaction->status }}

                    </span>
                    </span>
                </td>
               {{--  <td><input class="form-control" value="{{ $transaction->transaction_code }}"></td> --}}
                <td class="text-nowrap">&#8369; {{ $transaction->price }}/day</td>
                <td><input class="form-control mb-2" value="{{ $transaction->rent_date }}" readonly></td>
                <td><input class="form-control mb-2" value="{{ $transaction->return_date }}" readonly></td>
                <td>{{ $transaction->duration }} days</td>
                <td>&#8369; {{ $transaction->price * $transaction->duration }}</td>

                @php
                $total += $transaction->price * $transaction->duration;
                @endphp
            </tr>
            @endif
            @empty
            <tr>
                <td colspan="8" class="text-center">No item to show</td>
            </tr>
            @endforelse


            <tr>
                <td colspan="7" class="text-right">Total</td>
                <td colspan="1">&#8369; {{ $total }}</td>
            </tr>

        </tbody>
    </table>
</div>
@endsection
