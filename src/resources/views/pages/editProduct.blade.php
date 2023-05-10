@extends('layouts.app')

@section('title', 'Editar producto')

@section('content')
    @include('layouts.header')
    <main class="editor">
        <h1>Editar producto</h1>
        <section>
            <h2>Detalles</h2>
            <div>
                <form method="POST"
                    action="{{ route('pages.manageEditProductForms', [$product['id']]) }}?form=productDetails"
                    class="editor__password-content">
                    @csrf
                    <label for="form-name">Nombre</label>
                    <label for="form-description">Descripción</label>
                    <label for="form-price">Precio</label>
                    <input class="editor__input" type="text" value="{{ $product['name'] }}" id="form-name" name="name">
                    <textarea class="editor__input" rows="4" cols="20" name="description">{{ $product['description'] }}</textarea>
                    <input class="editor__input" type="number" value="{{ $product['price'] }}" id="form-price"
                        min="1" max="10000" name="price">
                    <input type="submit" value="GUARDAR" class="editor__save editor__data-details">
                </form>
            </div>
        </section>
        <section>
            <h2>Imágenes</h2>
             <form action="{{ route('pages.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" class="editor__data__logo-input" name="image" id="file-logoProfile">
                <img src="{{ asset(Auth::user()->pfp) }}" class="editor__data__logo-image">
                <label class="editor__data__logo-upload-label" for="file-logoProfile">Seleccionar imagen</label>
                <input type="submit" value="GUARDAR" class="editor__save editor__data-save">
            </form>
        </section>
        <section>
            <div>
                <h2>Subcategorias</h2>
                <form method="POST"
                    action="{{ route('pages.manageEditProductForms', [$product['id']]) }}?form=productSubcategory"
                    class="edit-product__form">
                    @csrf
                    @foreach ($subcategories as $subcategory)
                        @if ($subcategory[1] != null)
                            <input type="radio" name="subcategory" value="{{ $subcategory[0]['name'] }}"
                                id="{{ $subcategory[0]['name'] }}" checked>
                        @else
                            <input type="radio" name="subcategory" value="{{ $subcategory[0]['name'] }}"
                                id="{{ $subcategory[0]['name'] }}">
                        @endif
                        <label for="{{ $subcategory[0]['name'] }}">{{ $subcategory[0]['name'] }}</label>
                    @endforeach
                    <input type="hidden" name="id" value="{{ $product['id'] }}">
                    <input type="submit" value="GUARDAR" class="editor__save editor__data-save">
                </form>
            </div>
        </section>
        <section>
            <div>
                <h2>Estado</h2>
                <form method="POST"
                    action="{{ route('pages.manageEditProductForms', [$product['id']]) }}?form=productState"
                    class="editor__state-content">
                    @csrf
                    <label class="editor__state-item">Destacar</label>
                    <label class="editor__state-item editor__state-enable">Habilitar</label>
                    <label class="switch editor__state-item">
                        @if ($product->important)
                            <input type="checkbox" name="important" checked>
                        @else
                            <input type="checkbox" name="important">
                        @endif
                        <span class="slider round"></span>
                    </label>
                    <label class="switch editor__state-item">
                        @if ($product->enabled)
                            <input type="checkbox" name="enabled" checked>
                        @else
                            <input type="checkbox" name="enabled">
                        @endif
                        <span class="slider round"></span>
                    </label>
                    <input type="hidden" name="id" value="{{ $product['id'] }}">
                    <input type="submit" value="GUARDAR" class="editor__save editor__data-save">
                </form>
            </div>
        </section>
        <section>
            <form method="POST" action="{{ route('pages.deleteProduct', [$product['id']]) }}"
                class="editor__state-content">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" value="{{ $product['id'] }}">
                <input type="submit" value="ELIMINAR PRODUCTO" class="editor__data-logout">
            </form>


        </section>
    </main>
    @include('layouts.footer')

    <script src="{{ asset('js/profileManager.js') }}"></script>
@endsection
