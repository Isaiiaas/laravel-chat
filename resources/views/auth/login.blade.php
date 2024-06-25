@extends('auth.layouts')

@section('content')
<div class="row justify-content-center align-items-center h-100">
    <div class="col col-sm-6 col-md-6 col-lg-4 col-xl-3">
        <h3>Login</h3>
        <form method="POST" action="{{ route('userLogin') }}">
            <div class="form-group">
                <input type="text" class="form-control form-control-lg" placeholder="Email@example.com" id="email" name="email" value="{{ old('email') }}" required>
                @if ($errors->has('email'))
                <b>{{ $errors->first('email') }}</b>
                @endif
            </div>
            <div class="form-group">
                <input type="password" class="form-control form-control-lg" placeholder="Password" id="password" name="password" required>
                @if ($errors->has('password'))
                <b>{{ $errors->first('password') }}</b>
                @endif
            </div>
            <div class="form-group">
                @csrf
                <button class="btn btn-primary btn-lg btn-block" type="submit">Sign In</button>
            </div>
            <div class="form-group text-center">
                <p>New here? <a href="{{route('register')}}">Register</a></p>
            </div>
        </form>
    </div>
</div>