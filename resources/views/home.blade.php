@extends('layouts.app')

@section('title')
Home
@endsection

@section('content')

<div class="container">
    @if(session()->has('message'))
    <div class="alert alert-danger">
        {{ session()->get('message') }}
    </div>
    @endif
    <h1 class="text-center title " style="font-size:7em">Welcome</h1>

    <div id="carouselId" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselId" data-slide-to="0" class="active"></li>
            <li data-target="#carouselId" data-slide-to="1"></li>
            <li data-target="#carouselId" data-slide-to="2"></li>
            <li data-target="#carouselId" data-slide-to="3"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
                <img src="{{ asset('images/carousel/dims.jpg') }}" alt="first slide" height="650px" width="auto">
                <div class="carousel-caption d-none d-md-block">
                    <h3>Borderlands: The Handsome Collection</h3>
                    <p class="desc">Borderlands: The Handsome Collection is a compilation of first-person shooter video games developed by Gearbox Software and published by 2K Games.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/carousel/GOW.jpg') }}" alt="Second slide" height="650px" width="auto">
                <div class="carousel-caption d-none d-md-block">
                    <h3>God of war</h3>
                    <p class="desc">God of War is an action-adventure video game developed by Santa Monica Studio and published by Sony Interactive Entertainment. Released on April 20, 2018, for the PlayStation 4 console</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/carousel/sekiro.jpg') }}" alt="Third slide" height="650px" width="auto">
                <div class="carousel-caption d-none d-md-block">
                    <h3>Sekiro: Shadows Die Twice</h3>
                    <p class="desc">Sekiro: Shadows Die Twice is an action-adventure video game developed by FromSoftware and published by Activision. The game was released worldwide for Microsoft Windows, PlayStation 4</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/carousel/spidey.jpg') }}" alt="forth slide" height="650px" width="auto">
                <div class="carousel-caption d-none d-md-block">
                    <h3>Spider-Man</h3>
                    <p class="desc">Marvel's Spider-Man is a 2018 action-adventure game developed by Insomniac Games and published by Sony Interactive Entertainment. Based on the Marvel Comics superhero Spider-Man.</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselId" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselId" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>


</div>

@endsection
