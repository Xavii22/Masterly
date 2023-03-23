

@extends('layouts.app')

@section('title', 'Login page')

@section('content')     
    <form class="w3-container w3-card-4" action="{{ route('login') }}" method="post">
        @csrf
        <h2>Inicia sesión</h2>

        <p><input class="input-container {{ $errors->has('email') ? 'w3-border-red' : '' }}" type="text" name="email" placeholder="Correo electrónico"
                required autofocus value="{{ old('email') }}">
            @if ($errors->has('email'))
                <span class="w3-text-red"><strong>{{ $errors->first('email') }}</strong></span>
            @endif
        </p>

        <p><input class="input-container {{ $errors->has('password') ? 'w3-border-red' : '' }}" type="password" placeholder="Contraseña"
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
        <p><input class="w3-button w3-black" type="submit" value="Login!"></p>
        <p>¿Aún no te has registrado en nuestra página?  <a class="register-link" href="{{ route('pages.register') }}">¡Regístrate!</a></p>
    </form>
    
@endsection

