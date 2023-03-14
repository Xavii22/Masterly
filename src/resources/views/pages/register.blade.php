@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <form class="formulario">
        <h1>Registrate</h1>
        <div class="contenedor">
            <div class="input-contenedor">
                <img class="item" src="{{ asset('images/account.png') }}" alt="User">
                <input type="text" placeholder="Nombre de usuario">
            </div>
        </div>

    </form>
@endsection