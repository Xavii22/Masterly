@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <form class="formulario">
        <h1>Login</h1>
        <div class="contenedor">
            <div class="input-contenedor">
                <input type="text" placeholder="Correo electrónico">
            </div>
            <div class="input-contenedor">
                <input type="text" placeholder="Contraseña">
            </div>
        </div>
    </form>
@endsection
