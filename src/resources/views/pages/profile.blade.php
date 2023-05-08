@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    @include('layouts.header')
    <main class="profile">
        <form action="{{ route('pages.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <section class="profile__data">
                <h2 class="profile__data-title">Perfil</h2>
                <a class="profile__data-logout" href="{{ route('pages.logout') }}">Logout</a>
                <div class="profile__data__name">
                    <label class="data__logo-name">Nombre</label>
                    <input type="text" class="profile__input profile__data__name-input"
                        placeholder={{ Auth::user()->name }} value="{{ Auth::user()->name }}" name="name">
                </div>
                <div class="profile__data__logo">
                    <label class="profile__data__logo-label">Logo</label>
                    <input type="file" class="profile__data__logo-input" name="image" id="file-logoProfile">
                    @if (DB::table('users')->where('id', Auth::id())->value('pfp'))
                        <img src="{{ asset(Auth::user()->pfp) }}" class="profile__data__logo-image">
                    @else
                        {!! userCircle(Auth::user()->name) !!}
                    @endif
                    <div class="profile__data__logo-upload">
                        <img class="profile__data__logo-upload-image" src="{{ asset('images/upload.png') }}" alt="">
                        <label class="profile__data__logo-upload-label" for="file-logoProfile">Seleccionar imagen</label>
                    </div>
                </div>
                <button type="submit" class="profile__save profile__data-save">Guardar</button>

            </section>
        </form>
        <form action="{{ route('pages.changePassword') }}" method="POST">
            @csrf
            <section class="profile__password">
                <h2 class="profile__password-title">Contraseña</h2>
                <div class="profile__password-content">
                    <label class="password-content__label">Antigua contraseña</label>
                    <label class="password-content__label">Nueva contraseña</label>
                    <label class="password-content__label">Repetir contraseña</label>
                    <input class="profile__input" type="password" name="old_password" id="old_password">
                    <input class="profile__input" type="password" name="new_password" id="new_password">
                    <input class="profile__input" type="password" name="confirm_password" id="confirm_password">
                    <button type="submit" class="profile__save profile__password-save">Guardar</button>
                </div>
            </section>
        </form>

        <section class="profile__historical">
            <h2 class="profile__historical-title">Histórico de pedidos</h2>
        </section>

        <form action="{{ route('pages.createStore') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <section class="profile__shop">
                <h2 class="profile__shop-title">Tienda</h2>

                @if ($storeExists)
                @else
                <div storeExists="profile__shop-content">
                    <label class="shop-content__label">Nombre tienda</label>
                    <label class="shop-content__label">Logo tienda</label>
                    <input class="profile__input" type="text" name="name">
                    <input type="file" class="profile__input" name="image" id="file-logoShop">
                    <label class="profile__data__logo-upload-label" for="file-logoShop">Seleccionar imagen</label>
                    <button class="profile__save profile__shop-save">Crear</button>
                </div>

                @endif



            </section>
        </form>
    </main>
    @include('layouts.footer')

    <script src="{{ asset('js/profileManager.js') }}"></script>
@endsection
