@extends('layouts.app')

@section('title', 'Login page')

@section('content')     
    <form class="form-login-register" action="{{ route('login') }}" method="post">
        @csrf
        <h1 class="title-login-register">Inicia sesión</h1>

        <p><input class="input-login-register {{ $errors->has('email') ? 'w3-border-red' : '' }}" type="text" name="email" placeholder="Correo electrónico"
                required autofocus value="{{ old('email') }}">
            @if ($errors->has('email'))
                <span class="w3-text-red"><strong>{{ $errors->first('email') }}</strong></span>
            @endif
        </p>

        <p><input class="input-login-register {{ $errors->has('password') ? 'w3-border-red' : '' }}" type="password" placeholder="Contraseña"
                name="password" required autofocus value="">
            @if ($errors->has('password'))
                <span class="w3-text-red"><strong>{{ $errors->first('password') }}</strong></span>
            @endif
        </p>
        <!--
        <label>Remember me</label>
        <p><input class="w3-check" type="checkbox" name="remember" value="{{ old('remember') ? 'checked' : '' }}">
        </p>
        -->
        <p><input class="button button--blue" type="submit" value="Login!"></p>
        <a class="forgot-password-link" href="{{ route('pages.register') }}">¿Has olvidado la contraseña?</a>
        <p>¿Aún no te has registrado en nuestra página?  <a class="login-register-link" href="{{ route('pages.register') }}">¡Regístrate!</a></p>
    </form>
    
@endsection

