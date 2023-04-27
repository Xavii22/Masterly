@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    @include('layouts.header')
    <main class="profile">
        <section class="profile__logo">
            <h2 class="profile__logo-title">Logo</h2>
        </section>
        <section class="profile__name">
            <h2 class="profile__name-title">Nombre</h2>
        </section>
        <section class="profile__password">
            <h2 class="profile__password-title">Contraseña</h2>
        </section>
        <section class="profile__shop">
            <h2 class="profile__shop-title">Tienda</h2>
        </section>
    </main>
    @include('layouts.footer')
@endsection
