@extends('layouts.admin')
@section('pageName')
Dashboard
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">{{ __('Dashboard') }}</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

                Logged in as {{ auth()->user()->getRoleNames()->first() }}
        </div>
    </div>
</div>
@endsection
