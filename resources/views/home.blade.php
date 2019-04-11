@extends('layouts.app')

@section('title')
Home
@endsection

@section('content')

<div class="container">
    @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
    @endif
    <h1>Welcome</h1>
</div>

@endsection
