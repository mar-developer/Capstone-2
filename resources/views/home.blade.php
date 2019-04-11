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
    <h1 class="text-center title " style="font-size:15em">Welcome</h1>
</div>

@endsection
