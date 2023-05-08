@extends('layouts.app')

@section('title', 'Perfil')

@section('content')
    @include('layouts.header')
    <main class="editor">
        <form action="{{ route('pages.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <section class="editor__data">
                <h2 class="editor__data-title">Perfil</h2>
                <a class="editor__data-logout" href="{{ route('pages.logout') }}">Logout</a>
                <div class="editor__data__name">
                    <label class="data__logo-name">Nombre</label>
                    <input type="text" class="editor__input editor__data__name-input"
                        placeholder={{ Auth::user()->name }} value="{{ Auth::user()->name }}" name="name">
                </div>
                <div class="editor__data__logo">
                    <label class="editor__data__logo-label">Logo</label>
                    <input type="file" class="editor__data__logo-input" name="image" id="file-logoProfile">
                    @if (DB::table('users')->where('id', Auth::id())->value('pfp'))
                        <img src="{{ asset(Auth::user()->pfp) }}" class="editor__data__logo-image">
                    @else
                        {!! userCircle(Auth::user()->name) !!}
                    @endif
                    <div class="editor__data__logo-upload">
                        <img class="editor__data__logo-upload-image" src="{{ asset('images/upload.png') }}" alt="">
                        <label class="editor__data__logo-upload-label" for="file-logoProfile">Seleccionar imagen</label>
                    </div>
                </div>
                <button type="submit" class="editor__save editor__data-save">Guardar</button>

            </section>
        </form>
        <form action="{{ route('pages.changePassword') }}" method="POST">
            @csrf
            <section class="editor__password">
                <h2 class="editor__password-title">Contraseña</h2>
                <div class="editor__password-content">
                    <label class="password-content__label">Antigua contraseña</label>
                    <label class="password-content__label">Nueva contraseña</label>
                    <label class="password-content__label">Repetir contraseña</label>
                    <input class="editor__input" type="password" name="old_password" id="old_password">
                    <input class="editor__input" type="password" name="new_password" id="new_password">
                    <input class="editor__input" type="password" name="confirm_password" id="confirm_password">
                    <button type="submit" class="editor__save editor__password-save">Guardar</button>
                </div>
            </section>
        </form>

        <section class="editor__historical">
            <h2 class="editor__historical-title">Histórico de pedidos</h2>
        </section>

        <form action="{{ route('pages.createStore') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <section class="editor__shop">
                <h2 class="editor__shop-title">Tienda</h2>

                @if ($storeExists)
                    <a class="editor__save editor__shop-save" href="{{ route('pages.manageStore', ['id' => $storeName]) }}">Administrar productos</a>
                @else
                <div storeExists="editor__shop-content">
                    <label class="shop-content__label">Nombre tienda</label>
                    <label class="shop-content__label">Logo tienda</label>
                    <input class="editor__input" type="text" name="name">
                    <input type="file" class="editor__input" name="image" id="file-logoShop">
                    <label class="editor__data__logo-upload-label" for="file-logoShop">Seleccionar imagen</label>
                    <button class="editor__save editor__shop-save">Crear</button>
                </div>
                @endif



            </section>
        </form>
    </main>
    @include('layouts.footer')

    <script src="{{ asset('js/profileManager.js') }}"></script>
@endsection
