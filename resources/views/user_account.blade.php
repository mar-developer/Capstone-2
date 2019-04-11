@extends('layouts.app')

@section('title')
User Lists
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="overflow-y:auto">
                <div class="card-header text-center title" style="font-size:40pt">My Account</div>

                <div class="card-body">
                    <form method="POST" action="/UserAccount_update/{{ $user->id }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div style="margin-left:33%; margin-bottom:20px">
                            <div class="avatar-zone">
                                <img class="img-fluid output_image" style="object-fit:cover ; border-radius:50%;" src="{{ asset("images/profile/$user->img_path") }}" accept="image/*" onchange="preview_image(event)">
                            </div>

                            <input type="file" class="upload_btn image_input" name="image">
                            <div class="overlay-layer">Upload Image</div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">First Name</label>

                            <div class="col-md-8">
                                <input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ $user->first_name }}" required autofocus>

                                @if ($errors->has('first_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">Last Name</label>

                            <div class="col-md-8">
                                <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ $user->last_name }}" required autofocus>

                                @if ($errors->has('last_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">Address</label>

                            <div class="col-md-8">
                                <input id="address" type="text" class="form-control" name="address" value="{{ $user->address }}" required autofocus>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">Contact #</label>

                            <div class="col-md-8">
                                <input maxlength="11" id="contact_number" type="text" class="form-control{{ $errors->has('contact_number') ? ' is-invalid' : '' }}" name="contact_number" value="{{ $user->contact_number }}" required>

                                @if ($errors->has('contact_number'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('contact_number') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="email" class="col-md-3 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $user->email }}" {{ $user->email == "admin@admin.com" ? "readonly" : "" }} required>

                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <hr>
                        <div class="panel-group" id="accordion">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="btn btn-light col-md-12 btn-outline-info">
                                        Change Password
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in {{ $errors->has('password') ? 'show' : '' }}  {{ Session::has('message') ? 'show' : '' }}">
                                <div class="panel-body">


                                    <div class="form-group row">
                                        <label for="password" class="col-md-3  col-form-label text-md-right">Old Password</label>

                                        <div class="col-md-8">
                                            <input id="old_password" type="password" class="form-control{{ Session::has('message') ? ' is-invalid' : '' }}" name="old_password" placeholder="- Old Password -">

                                            @if (Session::has('message'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ Session::get('message') }}</strong>
                                            </span>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-md-3  col-form-label text-md-right">New Password</label>

                                        <div class="col-md-8">
                                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="- Change Password -">

                                            @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password-confirm" class="col-md-3  col-form-label text-md-right">Confirm Password</label>

                                        <div class="col-md-8">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="- Confirm Change Password -">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" style="width:100%">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
