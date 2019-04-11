@extends('layouts.app')

@section('title')
Requests
@endsection

@section('content')
<div class="container">


    <h1 class="text-center mb-5 title">Requests</h1>



    <table class="table table-striped table-bordered table-light">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Profile</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email Address</th>
                <th>Contact #</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php
            $counter = 0;
            $total = 0;
            @endphp

            {{-- @forelse ($items as $item) --}}
            @forelse ($users as $user)
            @php
            $transaction = \App\transactions::where('users_id', 2)->first();
            @endphp
            @if (!empty($transaction))
            @if ($user->id == $transaction->users_id)

            <tr>
                <td>{{ ++$counter }}</td>
                <td><img class="img-fluid" src="{{ asset("images/profile/$user->img_path") }}" style="height: 50px; width:50px; border-radius:50%"></td>
                <td>{{ ucfirst($user->first_name) }}</td>
                <td>{{ ucfirst($user->last_name) }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->contact_number }}</td>
                <td>
                    @if ($user->status == 'active')
                    <a class="btn btn-success active">{{ ucfirst($user->status) }}</a>
                    @elseif ($user->status == 'inactive')
                    <a class="btn btn-danger disabled">{{ $user->status }}</a>
                    @else
                    <a class="btn btn-warning">{{ $user->status }}</a>
                    @endif
                </td>
                <td>
                    <button class="btn btn-primary btn-edit" data-toggle="modal" data-target="#requests{{ $user->id }}">Request</button>
                </td>
            </tr>
            @endif
            @endif
            @empty
            <tr>
                <td colspan="8" class="text-center">No item to show</td>
            </tr>
            @endforelse

        </tbody>
    </table>




    {{-- request modal --}}
    @foreach ($users as $user)
    <div class="modal fade" id="requests{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 60%" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="my-modal-title"><img class="img-fluid" src="{{ asset("images/profile/$user->img_path") }}" style="height: 50px; width:50px; border-radius:50%">  {{ ucfirst($user->first_name) }} {{ ucfirst($user->last_name) }}  <span style="margin-left:700px">Access: {{ $user->access }}</span></h5>

                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h1 class="text-center mb-5 title" style="font-size:40pt">Transactions</h1>



                    <table class="table table-striped table-bordered table-light">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Details</th>
                                <th>Price</th>
                                <th>Rent Date</th>
                                <th>Return Date</th>
                                <th>Duration</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $counter = 0;
                            $total = 0;
                            $nice = '';
                            @endphp

                            {{-- @forelse ($items as $item) --}}
                            @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ ++$counter }}</td>
                                <td><img class="img-fluid" style="height:150px; width:150px; object-fit:contain" src="{{ asset("images/games/$transaction->img_path") }}" alt="{{ $transaction->img_path }}"></td>
                                <td><span>Title: {{ $transaction->name }}</span>
                                    <hr>
                                    <span>Transaction Code:
                                        <input class="form-control" value="{{ $transaction->transaction_code }}"></span>
                                        <hr>
                                            <form method="post" action="/Approve_request/{{$transaction->id}}/{{ $transaction->serial_code }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group row">
                                                    <label class="col-md-5">Item Status:</label>
                                                    <select class="form-control col-md-6" name="status" {{ $transaction->status == "returned" ? 'disabled' : '' }}>
                                                        <option value="approved" {{ $transaction->status == "approved" ? "Selected" : "" }}>Approved</option>
                                                        <option value="rejected" {{ $transaction->status == "rejected" ? "Selected" : "" }}>Rejected</option>
                                                        @if ($transaction->status == "rejected" || $transaction->status == "approved")
                                                        @else
                                                        <option value="pending" {{ $transaction->status == "pending" ? "Selected" : "" }}>Pending</option>
                                                        @endif
                                                        <option value="returned" {{ $transaction->status == "returned" ? "Selected" : "" }}>Returned</option>
                                                    </select>

                                                </div>
                                                <div class="form-group">
                                                    <button class="btn btn-primary col-md-12" {{ $transaction->status == "returned" ? 'disabled' : '' }}>Save Changes</button>
                                                </div>
                                                @if ($transaction->status == "returned")
                                                    <span class="text-danger" role="alert">
                                                        <strong>This has been returned</strong>
                                                    </span>
                                                @endif
                                            </form>
                                        </td>
                                        <td class="text-nowrap">&#8369; {{ $transaction->price }}/day</td>
                                        <td><input class="form-control mb-2" value="{{ $transaction->rent_date }}" readonly></td>
                                        <td><input class="form-control mb-2" value="{{ $transaction->return_date }}" readonly></td>
                                        <td>{{ $transaction->duration }} days</td>
                                        <td>&#8369; {{ $transaction->price * $transaction->duration }}</td>

                                        @php
                                        $total += $transaction->price * $transaction->duration;
                                        @endphp
                                    </tr>
                                    {{-- @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No item to show</td>
                                    </tr> --}}
                                    @endforeach


                                    <tr>
                                        <td colspan="7" class="text-right">Total</td>
                                        <td colspan="1">&#8369; {{ $total }}</td>
                                    </tr>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

            @endforeach

        </div>
        @endsection
