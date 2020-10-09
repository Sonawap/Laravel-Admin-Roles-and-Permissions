@extends('layouts.admin')
@section('pageName')
Permission
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Permissions Table</h3>
        <div class="card-tools">
            <a href="{{ route('permission.create') }}" class="btn btn-danger"><i class="fas fa-plus-circle"></i> Add new Permission</a>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Permission</th>
                    <th>Date Posted</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($permissions as $permission )
                    <tr>
                        <td>{{ $permission->id }}</td>
                        <td>{{ $permission->name }}</td>
                        <td><span class="tag tag-success">{{ $permission->created_at }}</span></td>
                        <td>
                            <a href="{{ route('permission.show', $permission->id ) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Edit Permission</a>
                            {{--  <a href="{{ route('permission.destroy', $permission->id ) }}" class="btn btn-danger">Delete</a>  --}}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td><i class="fas fa-folder-open"></i> No Record found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
