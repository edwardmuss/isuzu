@extends('layouts.default')

@section('content')

<div class="container"><br>
    <div class="container" style="margin-top: 60px; color: #000; font-weight: bolder;"><br><br><br>
        <h4> Welcome to Isuzu EA USSD Dashboard  </h4>
    </div>


    <form class="well"   style="max-width: 500px" method="POST" action="{{ route('login') }}" >
        <div class="col-md-12" style="">
            <b style="font-size: 15px">Please fill out the following fields to login</b>
            <hr>
        </div>

        @csrf
        <div class="login-wrap">
            <input id="email" type="email" placeholder="Email Address" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

            @if ($errors->has('email'))
                <span class="invalid-feedback" style="color:#F30000;">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
            @endif
            <br>
            <input id="password" placeholder="Enter your password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

            @if ($errors->has('password'))
                <span class="invalid-feedback" style="color:#F30000;">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
            @endif

            <div class="col-md-6 offset-md-4">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                    </label>
                </div>
            </div>

            <div class="" style="">
                <button class="btn btn-lg btn-block  btn-danger" name="log" type="submit"><i class="fa fa-sign-in"></i> Sign in</button>
            </div>
        </div>

    </form>
    <hr style="border:2px double #F30000">
</div>


@endsection
