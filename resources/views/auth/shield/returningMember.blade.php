@extends('auth.shield.layouts')
@section('content')
    <!-- Top content -->
    <div class="container" style="height: 1000% ! important;margin-top:145px;" >
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 text">
                <h1>Welcome Back!</h1>
            </div>
        </div>
        <br>
        <div class="row register-form" id="form-outer">
                <form method="POST" action="{{ url('/renewMembership') }}" style="width: 40%; margin: auto;">
                    @include('flashMessages')
                    @csrf
                        <div class="form-group">
                            <input id="email" type="email" placeholder="Enter Your Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert" style="color: rosybrown">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="member_id" placeholder="Enter Your Membership ID" class="form-control @error('member_id') is-invalid @enderror" name="member_id" value="{{ old('member_id') }}" required autocomplete="member_id" autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert" style="color: rosybrown">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input placeholder="Create New Password" class="form-control @error('npassword') is-invalid @enderror" name="npassword" autocomplete="npassword" required>
                            @error('npassword')
                            <span class="invalid-feedback" role="alert" style="color: rosybrown">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group" style="width: 70%; margin: auto;display: inline-block;">
                            <button type="submit" class="btn btn-primary" style="background-color:#3C8DBC;font-size: 20px">
                                {{ __('Renew Membership') }}
                            </button><br><br>
                            <div class="" style="margin: auto;font-size: large;color: black;">Have an account?
                                <a href="{{url('/login') }}">Login</a>
                            </div>
                        </div>
                </form>
        </div>
    </div>
@endsection()


