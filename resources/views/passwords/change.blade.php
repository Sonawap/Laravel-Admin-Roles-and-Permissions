@extends('layouts.admin')

@section('title')
change Password
@endsection

@section('bc')
Change Password
@endsection

@section('content')
<section class="content">
    <div class="card">
        <div class="card-header">
            <h4>Edit Profile</h4>
        </div>
        <div class="card-body">
            <div>
                <div>
                    <form class="form-horizontal" method="POST" action="{{ route('password.change') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="newpassword">Enter New Password</label>
                                    <input type="password" name="newpassword"  id="newpassword" class="form-control @error('newpassword') is-invalid @enderror" value="" required placeholder="New Password">
                                    @error('newpassword')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="newpassword_confirmation">Enter New Password</label>
                                    <input type="password" name="newpassword_confirmation"  id="newpassword_confirmation" class="form-control @error('newpassword_confirmation') is-invalid @enderror" value="" required placeholder="Confirm Password">
                                    @error('newpassword_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group button">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-lock"></i> Change Password</button>
                                    {{--  <a role="button" href="admin/index.html" class="bizwheel-btn theme-2">Login</a>  --}}
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection
