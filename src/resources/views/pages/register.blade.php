@extends('layouts.app')

@section('title', 'Register page')

@section('content')
    @include('layouts.header')
    <div class="form-login-register">


        <h1 class="title-login-register">Regístrate</h1>

        <input
            class="input-login-register textfield textfield--loginRegister  {{ $errors->has('name') ? 'w3-border-red' : '' }}"
            type="text" id="name" placeholder="Nombre de usuario" required autofocus value="{{ old('name') }}">
        @if ($errors->has('name'))
            <span class="w3-text-red"><strong>{{ $errors->first('name') }}</strong></span>
        @endif


        <input
            class="input-login-register textfield textfield--loginRegister  {{ $errors->has('email') ? 'w3-border-red' : '' }}"
            type="text" id="email" placeholder="Correo electrónico" required autofocus value="{{ old('email') }}">
        @if ($errors->has('email'))
            <span class="w3-text-red"><strong>{{ $errors->first('email') }}</strong></span>
        @endif


        <input
            class="input-login-register textfield textfield--loginRegister  {{ $errors->has('password') ? 'w3-border-red' : '' }}"
            type="password" placeholder="Contraseña" id="password" required value="">
        @if ($errors->has('password'))
            <span class="w3-text-red"><strong>{{ $errors->first('password') }}</strong></span>
        @endif


        <input class="input-login-register textfield textfield--loginRegister" type="password" id="password_confirmation"
            required value="" placeholder="Confirmar contraseña">

        <a href="{{ route('pages.login') }}"><input class="button-login-register button button--blue" type="submit"
                value="Register!"></a>

        <p>¿Ya tienes una cuenta en nuestra página? <a class="login-register-link" href="{{ route('pages.login') }}">¡Inicia
                sesió!</a></p>
    </div>
    <script src="{{ asset('js/registerLocalStorage.js') }}"></script>
@endsection
