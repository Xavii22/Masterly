

@extends('layouts.app')

@section('title', 'Register page')

@section('content')
    <form class="w3-container w3-card-4" action="{{ route('register') }}" method="post">
        @csrf
        <h2>Register User</h2>

        <p><input class="w3-input w3-border {{ $errors->has('name') ? 'w3-border-red' : '' }}" type="text" name="name"
                required autofocus value="{{ old('name') }}">
            @if ($errors->has('name'))
                <span class="w3-text-red"><strong>{{ $errors->first('name') }}</strong></span>
            @endif
        </p>

        <p><input class="w3-input w3-border {{ $errors->has('email') ? 'w3-border-red' : '' }}" type="text" name="email"
                required autofocus value="{{ old('email') }}">
            @if ($errors->has('email'))
                <span class="w3-text-red"><strong>{{ $errors->first('email') }}</strong></span>
            @endif
        </p>

        <p><input class="w3-input w3-border {{ $errors->has('password') ? 'w3-border-red' : '' }}" type="password"
                name="password" required value="">
            @if ($errors->has('password'))
                <span class="w3-text-red"><strong>{{ $errors->first('password') }}</strong></span>
            @endif
        </p>

        <p><input class="w3-input w3-border" type="password" name="password_confirmation" required value=""></p>

        <p><input class="w3-button w3-black" type="submit" value="Register!"></p>

        <p>¿Ya tienes una cuenta en nuestra página? <a href="{{ route('pages.login') }}">¡Inicia sesió!</a></p> 
    </form>
@endsection

