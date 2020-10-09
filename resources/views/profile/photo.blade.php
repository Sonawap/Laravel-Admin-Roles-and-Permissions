@extends('layouts.admin')

@section('pageName')
Profile Photo
@endsection


@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Change Profile Image</h3>
    </div>
    <div class="card-body">
        <upload></upload>
    </div>
</div>
@endsection
