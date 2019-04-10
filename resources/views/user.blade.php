@extends('layouts.app')

@section('title')
User Lists
@endsection

@section('content')
<div class="container">

    <h1 class="text-center"> User List</h1>

    <table class="table table-light">
        <thead class="thead-light">
            <tr>
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
            @forelse ($users as $user)
            <tr>
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
                    <button class="btn btn-primary btn-edit" {{ $user->email == "admin@admin.com" ? "disabled" : "" }} data-toggle="modal" data-target="#edit-modal{{ $user->id }}">Edit</button>
                    <button class="btn btn-danger" {{ $user->email == "admin@admin.com" ? "disabled" : "" }} {{ $user->access == "admin" ? "disabled" : "" }} data-toggle="modal" data-target="#delete_modal{{ $user->id }}">Delete</button>
                </td>
            </tr>
            @empty

            @endforelse
        </tbody>
    </table>

    @foreach ($users as $user)
    <div id="edit-modal{{ $user->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Edit</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/user/{{ $user->id }}">
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


                        <hr>

                        <div class="text-right">
                            <button class="btn btn-primary">Confirm</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @endforeach

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
