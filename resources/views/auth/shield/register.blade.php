@extends('auth.shield.layouts')

@section('content')
    <!-- Top content -->
    <div class="top-content">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text">
                    <h1 style="font-weight: bolder;color: #3C8DBC   ;">Membership Registration</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1 show-forms">
                    <span class="show-register-form active"></span>
                </div>
            </div>
            <br>
            <div class="row register-form">
                <div class="col-sm-4 col-sm-offset-1">
                    @include('flashMessages')
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-12 col-sm-12 col-lg-12">
                                <input id="name" placeholder="Enter Your FullName" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert" style="color: rosybrown">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12 col-sm-12 col-lg-12">
                                <input id="ippis_no" placeholder="Enter Your IPPIS Number"  class="form-control @error('ippis_no') is-invalid @enderror" name="ippis_no" value="{{ old('ippis_no') }}" required>
                                @error('ippis_no')
                                <span class="invalid-feedback" role="alert" style="color: rosybrown">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12 col-sm-12 col-lg-12">
                                <input id="email" type="email" placeholder="Enter Your Email"  class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert" style="color: rosybrown">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 col-ms-12 col-lg-12">
                                <input id="phone_no" type="" placeholder="Enter Your Phone Number" class="form-control @error('phone_no') is-invalid @enderror" name="phone_no" required >
                                @error('phone_no')
                                <span class="invalid-feedback" role="alert" style="color: rosybrown">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 col-ms-12 col-lg-12">
                                <input id="password-confirm" type="" placeholder="Enter Your Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert" style="color: rosybrown">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 col-ms-12 col-lg-12">
                                <input id="password-confirm" type="" placeholder="Confirm Your Password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                @error('password-confirm')
                                <span class="invalid-feedback" role="alert" style="color: rosybrown">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0 pull-left">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" style="background: #3C8DBC;font-size: 15px">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                        <div class="pull-left"style="font-size: large; color: black;">&#160;&#160;
                            Already registered?
                            <a href="{{url('/login') }}" style="color:#3C8DBC">Login</a></div>
                    </form>
                </div>
                <div class="col-sm-6 forms-right-icons" style="top:-20px ! important" ">
                <div class="row">
                    <div class="col-sm-2 icon"><i class="fa fa-group"></i></div>
                    <div class="col-sm-10">
                        <h2>Together we are stronger</h2>
                        <p style="color: black;font-size: 20px">We believe in unity for the benefit of all.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2 icon"><i class="fa fa-life-saver"></i></div>
                    <div class="col-sm-10">
                        <h2>Nepza cooperative</h2>
                        <p style="color: black;font-size: 20px">Aims to improve the living standard of its members through the culture of saving</p>
                    </div>
                </div>
            </div>
            </div>

        </div>
    </div>
@endsection
