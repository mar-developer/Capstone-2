@extends('layouts.app')

@section('title')
Items
@endsection

@section('content')
<div class="container">

    <h1 class="text-center title">Games</h1>
    @if ($errors->any())
    <div class='alert alert-danger'>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <table class="table table-light table-bordered table-striped">
        <thead class="thead-light">
            <tr>
                <th class="text-center">#</th>
                <th class="text-center" style="width:200px">Image</th>
                <th class="text-center">Name</th>
                <th class="text-center" style="width:500px">Description</th>
                <th class="text-center">Price</th>
                <th class="text-center">Category</th>
                <th class="text-center"a>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $index => $item)
            <tr>
                <td>{{ ++$index }}</td>
                <td><img class="img-fluid" style="height:150px; width:150px; object-fit:contain" src="{{ asset("images/games/$item->img_path") }}" alt="{{ $item->img_path }}"></td>
                <td style="width:200px" class="text-center">{{ $item->name }}
                <hr>
                <span class="text-nowrap">
                    No. of available copies: {{  $count = \App\serials::where('items_id', $item->id)->where('status','available')->count() }}
                </span>
                <span>
                    for approval: {{  $count = \App\serials::where('items_id', $item->id)->where('status','for approval')->count() }}
                </span>

                </td>
                <td>{{ $item->description }}</td>
                <td class="text-nowrap">&#8369; {{ $item->price }}/day</td>
                <td class="text-nowrap">{{ $item->category }}</td>
                <td>
                    <div class="text-nowrap">

                        <button class="btn btn-primary edit-btn" data-toggle="modal" data-target="#edit_item{{ $item->id }}">Edit</button>
                        <button class="btn btn-danger" data-toggle="modal" data-target="#delete_item{{ $item->id }}">Delete</button>
                    </div>
                </td>
            </tr>

            @empty
            <tr>
                <td colspan="7" class="text-center">No Item Available</td>
            </tr>
            @endforelse
        </tbody>
    </table>



    {{-- Add item modal --}}
    <div>
        <button class="btn btn-success add_item" data-toggle="modal" data-target="#add_item" type="button"><i class="fas fa-plus"></i></button>
    </div>

    <div class="modal fade" id="add_item" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:900px" role="document">
            <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title" style="margin-left:400px" id="my-modal-title">Add Game</h5>

                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/AddItem" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group form-row">
                            <div class="form-group col-md-4">
                                <div class="avatar-zone">
                                    <img class="img-fluid output_image" style="object-fit:contain" src="{{ asset('images/icons/add_image.png') }}" accept="image/*" onchange="preview_image(event)">
                                </div>

                                <input type="file" class="upload_btn image_input" name="image" required>
                                <div class="overlay-layer">Upload Image</div>

                                @if ($errors->has('image'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                                @endif

                                <div class="form-group mt-3">
                                    <label>Category</label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="category">
                                            <option disabled selected>Select a genre</option>
                                            <option value="RPG">RPG</option>
                                            <option value="Sports">Sports</option>
                                            <option value="Survival">Survival</option>
                                            <option value="Simulation">Simulation</option>
                                            <option value="Puzzle">Puzzle</option>
                                            <option value="First Person Shooter">First Person Shooter</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-8">

                                <div class="form-group">
                                    <label>Game Title</label>
                                    <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }} col-md-10" type="text" name="name" value="{{ old('name') }}" required>

                                    @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>Price</label>
                                    <input class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }} col-md-10" type="number" name="price" value="{{ old('price') }}" required>

                                    @if ($errors->has('price'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                    @endif
                                </div>



                                <div class="form-group">

                                    <label >Game Description</label>
                                    <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }} col-md-10 game_desc" id="contentbox" maxlength="191"  type="text" name="description" rows="5" cols="42" style="text-align:left" required>{{ old('description') }}</textarea>
                                    <div>Remaining character left:
                                    <div id="count">191</div>
                                    <div id="barbox"><div id="bar"></div></div>
                                    </div>

                                    @if ($errors->has('description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            </div>
                        </div>

                        <div class="text-right" style="padding:10px">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit item modal --}}
    @foreach ($items as $item)
    <div class="modal fade" id="edit_item{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 60%" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title" style="margin-left:50%">Edit Game</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/Edit_item/{{ $item->id }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group form-row">
                            <div class="form-group col-md-4">
                                <div class="avatar-zone">
                                    <img class="img-fluid output_image" style="object-fit:contain" src="{{ asset("images/games/$item->img_path") }}" accept="image/*" onchange="preview_image(event)">
                                </div>

                                <input type="file" class="upload_btn image_input" name="image" >
                                <div class="overlay-layer">Upload Image</div>

                                <div class="form-group" style="padding-top: 50px">
                                    <label>Game Title</label>
                                    <input class="form-control col-md-10" type="text" name="name" value="{{ $item->name }}" required>

                                </div>

                                <div class="form-group">
                                    <label>Price</label>
                                    <input class="form-control col-md-10" type="number" name="price" value="{{ $item->price }}" required>

                                </div>

                                <div class="form-group">
                                    <label>Category</label>
                                    <select class="form-control col-md-10" name="category">
                                        <option value="RPG" {{ $item->category == "RPG" ? "Selected" : "" }}>RPG</option>
                                        <option value="Sports" {{ $item->category == "Sports" ? "Selected" : "" }}>Sports</option>
                                        <option value="Survival" {{ $item->category == "Survival" ? "Selected" : "" }}>Survival</option>
                                        <option value="Simulation" {{ $item->category == "Simulation" ? "Selected" : "" }}>Simulation</option>
                                        <option value="Puzzle" {{ $item->category == "Puzzle" ? "Selected" : "" }}>Puzzle</option>
                                        <option value="FPS" {{ $item->category == "FPS" ? "Selected" : "" }}>FPS</option>
                                    </select>
                                </div>

                            </div>
                            <div class="form-group col-md-8">


                                <div class="form-group">
                                    <label >Game Description</label>
                                    <textarea class="form-control col-md-10" type="text" name="description" rows="5" style="text-align:left" required>{{ $item->description }}</textarea>

                                </div>

                                <hr>
                                <h3 class="text-center">Game Copies</h3>

                                <a class="btn btn-primary col-md-10 ml-5 m-3" href="/add_copy/{{ $item->id }}">Add a copy</a>

                                <div class="form-group">
                                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                        <table class="table table-light table-bordered table-striped">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">Serial #</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $item_no = 0;
                                                @endphp
                                                @forelse ($serials as $index => $serial)
                                                @if ($serial->items_id == $item->id)
                                                <tr>
                                                    <td>{{ ++$item_no }}</td>
                                                    <td>
                                                        @if ($serial->serial_code == $item->serial_code)
                                                        {{ $serial->serial_code }} <span style="font-weight:bold; float:right">(Current Item)</span>
                                                        @else
                                                        {{ $serial->serial_code }}
                                                        @endif
                                                    </td>

                                                    <td
                                                    @if ($serial->status == "available")
                                                    class="btn btn-success ml-4 mt-1"
                                                    @elseif($serial->status == "barrowed")
                                                    class="btn btn-info ml-4 mt-1"
                                                    @elseif($serial->status == "for approval")
                                                    class="btn btn-warning ml-4 mt-1"
                                                    @elseif($serial->status == "damaged")
                                                    class="btn btn-danger ml-4 mt-1"
                                                    @endif
                                                    >
                                                    {{ $serial->status }}
                                                </td>
                                                <td>
                                                    <a

                                                    @if ($serial->serial_code == $item->serial_code)
                                                    class="btn btn-danger disabled"
                                                    @else
                                                    class="btn btn-danger"
                                                    @endif

                                                    href="/delete_serial/{{ $serial->id }}"><i class="fas fa-trash-alt"></i></a>
                                                </td>
                                            </tr>
                                            @endif
                                            @empty
                                            <tr>
                                                <td colspan="3" class="text-center">No Item Available</td>
                                            </tr>
                                            @endforelse

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="text-right" style="padding:10px">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endforeach



{{-- Delete item modal --}}
@foreach ($items as $item)
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true" id="delete_item{{ $item->id }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Delete Game</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="/DeleteItem/{{ $item->id }}">
                    @csrf
                    @method('DELETE')
                    Are you sure you want to delete {{ $item->name }}?

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
