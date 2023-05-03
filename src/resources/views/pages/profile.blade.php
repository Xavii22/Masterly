@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    @include('layouts.header')
    <main class="editor">
        <section class="editor__data">
            <h2 class="editor__data-title">Perfil</h2>
            <a class="editor__data-logout" href="{{ route('pages.logout') }}">Logout</a>
            <div class="editor__data__name">
                <label class="data__logo-name">Nombre</label>
                <input type="text" class="editor__input editor__data__name-input" placeholder= {{ Auth::user()->name }}>
            </div>
            <div class="editor__data__logo">
                <label class="editor__data__logo-label">Logo</label>
                <input type="file" class="editor__data__logo-input" id="file-logo">
                <img src="{{ asset('images/user.png') }}" class="editor__data__logo-image">
                <div class="editor__data__logo-upload">
                    <img class="editor__data__logo-upload-image" src="{{ asset('images/upload.png') }}" alt="">
                    <label class="editor__data__logo-upload-label" for="file-logo">Seleccionar imagen</label>
                </div>
            </div>
            <button class="editor__save editor__data-save">Guardar</button>
        </section>
        <section class="editor__password">
            <h2 class="editor__password-title">Contraseña</h2>
            <div class="editor__password-content">
                <label class="password-content__label">Antigua contraseña</label>
                <label class="password-content__label">Nueva contraseña</label>
                <label class="password-content__label">Actual contraseña</label>
                <input class="editor__input" type="text">
                <input class="editor__input" type="text">
                <input class="editor__input" type="text">
                <button class="editor__save editor__password-save">Guardar</button>
            </div>
        </section>
        <section class="editor__historical">
            <h2 class="editor__historical-title">Histórico de pedidos</h2>

        </section>
        <section class="editor__shop">
            <h2 class="editor__shop-title">Tienda</h2>
            <div class="editor__shop-content">
                <label class="shop-content__label">Nombre tienda</label>
                <label class="shop-content__label">Logo tienda</label>
                <input class="editor__input" type="text">
                <img src="{{ asset('images/user.png') }}" class="editor__data__logo-image">
                <button class="editor__save editor__shop-save">Crear</button>
            </div>
        </section>
    </main>
    @include('layouts.footer')

    <script src="{{ asset('js/profileManager.js') }}"></script>
@endsection
