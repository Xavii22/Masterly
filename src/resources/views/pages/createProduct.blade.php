@extends('layouts.app')

@section('title', 'Crear producto')

@section('content')
    @include('layouts.header')
    <main class="editor">
        <h1>Crear producto</h1>
        <form action="{{ route('pages.createProduct') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <section>
                <h2>Detalles</h2>
                <div class="editor__details">
                    <label for="form-name">Nombre</label>
                    <label for="form-description">Descripción</label>
                    <label for="form-price">Precio</label>
                    <input class="editor__input" type="text" id="form-name" name="name">
                    <textarea class="editor__input" rows="4" cols="20" id="form-description" name="description"></textarea>
                    <input class="editor__input" type="number" id="form-price" min="1" max="10000"name="price">
                </div>
            </section>
            <section>
                <h2>Imágenes</h2>
                @for ($i = 1; $i <= env('MAX_IMAGES'); $i++)
                    <input type="file" name="image_{{ $i }}" id="image_{{ $i }}"
                        onchange="validateImage(event, {{ $i }})">
                    <span id="error_{{ $i }}" style="color: red;"></span>
                @endfor
                {{-- <input type="file" class="editor__data__logo-input" name="image" id="file-image" multiple>
                <div class="image-preview"></div>
                <label class="editor__data__logo-upload-label" for="file-image">Seleccionar imagen</label>
                <span class="error-message"></span> --}}
            </section>
            <section>
                <div>
                    <h2>Subcategorias</h2>
                    @foreach ($subcategories as $subcategory)
                        <input type="radio" name="subcategory" value="{{ $subcategory->name }}"
                            id="{{ $subcategory->name }}" checked>
                        <label for="{{ $subcategory->name }}">{{ $subcategory->name }}</label>
                    @endforeach
                </div>
            </section>
            <section>
                <div>
                    <h2>Estado</h2>
                    <label class="editor__state-item">Destacar</label>
                    <label class="editor__state-item editor__state-enable">Habilitar</label>
                    <label class="switch editor__state-item">
                        <input type="checkbox" name="important">
                        <span class="slider round"></span>
                    </label>
                    <label class="switch editor__state-item">
                        <input type="checkbox" name="enabled">
                        <span class="slider round"></span>
                    </label>
                </div>
            </section>
            <input type="submit" value="GUARDAR" class="editor__save editor__data-save">
        </form>
    </main>
    @include('layouts.footer')

    <script src="{{ asset('js/createProductManager.js') }}"></script>
@endsection
