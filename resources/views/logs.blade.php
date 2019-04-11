@extends('layouts.app')

@section('title')
Home
@endsection

@section('content')
<div class="container">
@php
    $counter=0;
@endphp
<div class="col-md-12">
    <table class="table table-striped table-bordered table-dark">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Action</th>
            <th>Status</th>
            <th>Updated</th>
        </tr>
            @forelse($logs as $log)
            @if ($log->user_id == Auth::user()->id)
            <tr>
                <td>{{ ++$counter }}</td>
                <td class="text-nowrap">{{ $log->name }}</td>
                <td class="text-nowrap">{{ $log->action }}</td>
                <td class="text-nowrap" >{{ $log->status}}</td>
                <td class="text-nowrap">{{ $log->created_at->diffForHumans() }}</td>
            </tr>

            @endif
            @empty
             <tr>
                <td colspan="5" class="text-center">No History found Found</td>
            </tr>
            @endforelse

    </table>
</div>




</div>
@endsection
