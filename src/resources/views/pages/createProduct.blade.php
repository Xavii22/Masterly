@extends('layouts.app')

@section('title', 'Crear producto')

@section('content')
    @include('layouts.header')
    <main class="creator">
        <h1>Crear producto</h1>
        <form action="{{ route('pages.createProduct') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <section>
                <h2>Detalles</h2>
                <div>
                    <label for="form-name">Nombre</label>
                    <label for="form-description">Descripción</label>
                    <label for="form-price">Precio</label>
                    <input class="creator__input" type="text" id="form-name" name="name">
                    <textarea class="creator__input" rows="4" cols="20" id="form-description" name="description"></textarea>
                    <input class="creator__input" type="number" id="form-price" min="1" max="10000"
                        name="price">
                </div>
            </section>
            <section>
                <h2>Imágenes</h2>
                <input type="file" class="creator__data__logo-input" name="image" id="file-logoProfile">
                {{-- <img src="{{ asset(Auth::user()->pfp) }}" class="creator__data__logo-image"> --}}
                <label class="creator__data__logo-upload-label" for="file-logoProfile">Seleccionar imagen</label>
            </section>
            <section>
                <div>
                    <h2>Subcategorias</h2>
                    @foreach ($subcategories as $subcategory)
                        <input type="radio" name="subcategory" value="{{ $subcategory->name }}"
                            id="{{ $subcategory->name }}" checked>
                        <label for="{{ $subcategory->name }}">{{ $subcategory->name }}</label>
                    @endforeach
                    <input type="submit" value="GUARDAR" class="creator__save creator__data-save">
                </div>
            </section>
            <section>
                <div>
                    <h2>Estado</h2>
                    <label class="creator__state-item">Destacar</label>
                    <label class="creator__state-item creator__state-enable">Habilitar</label>
                    <label class="switch creator__state-item">
                        <input type="checkbox" name="important">
                        <span class="slider round"></span>
                    </label>
                    <label class="switch creator__state-item">
                        <input type="checkbox" name="enabled">
                        <span class="slider round"></span>
                    </label>
                </div>
            </section>
            <input type="submit" value="GUARDAR" class="creator__save creator__data-save">
        </form>
    </main>
    @include('layouts.footer')

    <script src="{{ asset('js/profileManager.js') }}"></script>
@endsection
