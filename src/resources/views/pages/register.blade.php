@extends('layouts.app')

@section('title', 'Register page')

@section('content')
    <h1 class="title">Register</h1>

    <input class="input-login-register {{ $errors->has('name') ? 'w3-border-red' : '' }}" type="text" id="name"
        placeholder="Nombre de usuario" required autofocus value="{{ old('name') }}">
    @if ($errors->has('name'))
        <span class="w3-text-red"><strong>{{ $errors->first('name') }}</strong></span>
    @endif


    <input class="input-login-register {{ $errors->has('email') ? 'w3-border-red' : '' }}" type="text" id="email"
        placeholder="Correo electrónico" required autofocus value="{{ old('email') }}">
    @if ($errors->has('email'))
        <span class="w3-text-red"><strong>{{ $errors->first('email') }}</strong></span>
    @endif


    <input class="input-login-register {{ $errors->has('password') ? 'w3-border-red' : '' }}" type="password"
        placeholder="Contraseña" id="password" required value="">
    @if ($errors->has('password'))
        <span class="w3-text-red"><strong>{{ $errors->first('password') }}</strong></span>
    @endif


    <input class="input-login-register" type="password" id="password_confirmation" required value=""
        placeholder="Confirmar contraseña">

    <input class="button button--blue" type="submit" value="Register!">

    <p>¿Ya tienes una cuenta en nuestra página? <a href="{{ route('pages.login') }}">¡Inicia sesió!</a></p>

    <script src="{{ asset('js/registerLocalStorage.js') }}"></script>

    <form class="form-login-register" action="{{ route('register') }}" method="post">
        @csrf
        <h1 class="title-login-register">Regístrate</h1>

        <p><input class="textfield textfield--loginRegister  {{ $errors->has('name') ? 'w3-border-red' : '' }}" type="text" name="name" placeholder="Nombre de usuario"
                required autofocus value="{{ old('name') }}">
            @if ($errors->has('name'))
                <span class="w3-text-red"><strong>{{ $errors->first('name') }}</strong></span>
            @endif
        </p>

        <p><input class="textfield textfield--loginRegister  {{ $errors->has('email') ? 'w3-border-red' : '' }}" type="text" name="email" placeholder="Correo electrónico"
                required autofocus value="{{ old('email') }}">
            @if ($errors->has('email'))
                <span class="w3-text-red"><strong>{{ $errors->first('email') }}</strong></span>
            @endif
        </p>

        <p><input class="textfield textfield--loginRegister  {{ $errors->has('password') ? 'w3-border-red' : '' }}" type="password" placeholder="Contraseña"
                name="password" required value="">
            @if ($errors->has('password'))
                <span class="w3-text-red"><strong>{{ $errors->first('password') }}</strong></span>
            @endif
        </p>

        <p><input class="textfield textfield--loginRegister" type="password" name="password_confirmation" required value="" placeholder="Confirmar contraseña"></p>

        <p><input class="button button--blue" type="submit" value="Register!"></p>
        
        <p>¿Ya tienes una cuenta en nuestra página? <a class="login-register-link" href="{{ route('pages.login') }}">¡Inicia sesió!</a></p> 
    </form>
@endsection
