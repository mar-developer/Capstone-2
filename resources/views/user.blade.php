@extends('layouts.app')

@section('title')
User Lists
@endsection

@section('content')
<div class="container">
    <h1 class="text-center title"> Users </h1>

    @forelse ($users as $user)
    <div class="col-md-4 float-left">
        <div class="card ">
            <img class="img-fluid mt-4" src="{{ asset("images/profile/$user->img_path") }}" style="height: 200px; width:200px; border-radius:50%; margin-left: 20%">
            <div class="card-body">
                <h5 class="card-title mb-4 text-left ml-3"><span style="margin-left:20px" class="text-nowrap">
                    @if ($user->status == 'active')
                    <a class="btn btn-success btn-sm active">{{ ucfirst($user->status) }}</a>
                    @elseif ($user->status == 'inactive')
                    <a class="btn btn-danger disabled btn-sm">{{ $user->status }}</a>
                    @else
                    <a class="btn btn-warning btn-sm">{{ $user->status }}</a>
                    @endif
                </span>
                {{ ucfirst($user->first_name) }} {{ ucfirst($user->last_name) }}
            </h5>
            <hr>

            <p class="card-text">{{ $user->email }}</p>
            <p class="card-text mt-2">{{ $user->contact_number }}</p>
        </div>
        <div class="panel-group" id="accordion">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="{{ $user->email == "admin@admin.com" ? "" : "collapse" }}" data-parent="#accordion" href="#collapseOne{{ $user->id }}" class="btn btn-light col-md-11 ml-3  btn-outline-info">
                        Edit Access
                    </a>
                </h4>
            </div>
            <div id="collapseOne{{ $user->id }}" class="panel-collapse collapse in">

                <form action="/user/{{ $user->id }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-md-right">Status</label>

                        <div class="col-md-8">
                            <select class="form-control" name="status">
                                <option value="active" {{ $user->status == "active" ? "Selected" : "" }}>Active</option>
                                <option value="inactive" {{ $user->status == "inactive" ? "Selected" : "" }}>Inactive</option>
                                @if ($user->status == "active" || $user->status == "inactive")

                                @else
                                <option value="pending" {{ $user->status == "pending" ? "Selected" : "" }}>Pending</option>

                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-md-right">Access</label>

                        <div class="col-md-8">
                            <select class="form-control" name="access" {{ $user->access == "super_admin" ? "disabled" : "" }}>
                                <option value="admin" {{ $user->access == "admin" ? "Selected" : "" }}>Admin</option>
                                <option value="user" {{ $user->access == "user" ? "Selected" : "" }}>User</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary mb-2 mr-2">Confirm</button>
                    </div>
                </form>

            </div>
        </div>

        <div class="card-footer bg-transparent text-right">
            <button class="btn btn-primary btn-edit" {{ $user->email == "admin@admin.com" ? "disabled" : "" }} ><i class="fas fa-edit    "></i></button>
            <button class="btn btn-danger" {{ $user->email == "admin@admin.com" ? "disabled" : "" }} {{ $user->access == "admin" ? "disabled" : "" }} data-toggle="modal" data-target="#delete_modal{{ $user->id }}"><i class="fa fa-trash" aria-hidden="true"></i></button>

        </div>
    </div>
</div>
@empty

@endforelse
@foreach ($users as $user)
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Delete User" aria-hidden="true" id="delete_modal{{ $user->id }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Delete User</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="/user/{{ $user->id }}">
                    @csrf
                    @method('DELETE')

                    Are you sure you want to delete {{ ucfirst($user->first_name) }}'s account?

                    <hr>
                    <div class="text-right">

                        <button class="btn btn-danger">Delete</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

</div>



@endsection
