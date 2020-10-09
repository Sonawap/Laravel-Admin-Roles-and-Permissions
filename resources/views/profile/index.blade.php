@extends('layouts.admin')

@section('pageName')
Profile
@endsection
@section('content')
<section class="content">
    <div class="">
        <div class="row">
            <div class="col-md-3">

                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                        @if (auth()->user()->photo == 'avatar.jpg')
                            <img style="width: 200px;" class="profile-user-img img-fluid img-circle" src="{{ asset('assets/img/avatar.jpg') }}" alt="{{ auth()->user()->name . ' Photo' }}">
                        @else
                            <img style="width: 200px;" class="profile-user-img img-fluid img-circle" src="{{ asset('assets/profile/') .'/'. auth()->user()->photo }}" alt="{{ auth()->user()->name . ' Photo' }}">
                        @endif

                        </div>

                        <h3 class="profile-username text-center" style="text-transform: uppercase">{{ auth()->user()->name }} </h3>
                        <p class="text-muted text-center">{{ auth()->user()->role }}</p>
                        <p class="text-muted text-center">{{ auth()->user()->email }}</p>
                        <p class="text-muted text-center">{{ auth()->user()->phone }}</p>

                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body">
                        <div>

                            <div>
                                <form class="form-horizontal" method="POST" action="{{ route('profile.update', auth()->user()->id) }}">
                                    @csrf
                                    @method('put')
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" name="name"  id="name" class="form-control @error('email') is-invalid @enderror" value="{{ auth()->user()->name }}" required placeholder="Name">
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="email">Email Address</label>
                                                <input type="email" name="email"  id="email" class="form-control @error('email') is-invalid @enderror" value="{{ auth()->user()->email }}" placeholder="E-mail Address">
                                                @error('siteemail')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="phone">Phone Number</label>
                                                <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Phone Number" value="{{ auth()->user()->phone }}" required>
                                                @error('phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>


                                        </div>
                                        {{-- <div class="col-12">
                                            <div class="form-group">
                                                <div class="icon"><i class="fa fa-lock"></i></div>
                                                <input id="password" placeholder="Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                        </div> --}}
                                        <div class="col-12">
                                            <div class="form-group button">
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-user-edit"></i> Update Profile</button>
                                                {{--  <a role="button" href="admin/index.html" class="bizwheel-btn theme-2">Login</a>  --}}
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
