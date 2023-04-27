@extends('layouts.app')

@section('title', 'Editar producto')

@section('content')
    @include('layouts.header')
    <main class="edit-product">
        <h1>Editar producto</h1>
        <section class="edit-product__section">
            <div>
                <h2>Detalles</h2>
                <form method="POST" action="{{ route('pages.editDetails', [$product['id']]) }}" class="edit-product__form">
                    @csrf
                    <label for="form-name">Nombre</label>
                    <input type="text" value="{{ $product['name'] }}" id="form-name" name="name">
                    <label for="form-description">Descripción</label>
                    <textarea rows="4" cols="20" name="description">{{ $product['description'] }}</textarea>
                    <label for="form-price">Precio</label>
                    <input type="number" value="{{ $product['price'] }}" id="form-price" min="1" max="10000" name="price">
                    <input type="submit" value="GUARDAR" class="button button--blue introduction__button">
                </form>                
            </div>
        </section>
        <section class="edit-product__section">
            <div>
                <h2>Categorias</h2>
            </div>
        </section>
        <section class="edit-product__section">
            <div>
                <h2>Estado</h2>
                <form action="" class="edit-product__state-form">
                    @csrf
                    <label for="form-important">Destacar</label>
                    <label for="form-enable">Habilitar</label>
                    
                    <img src="{{ asset('images/trash.png') }}" class="product-item__image-trash">
                    <label class="switch">
                        @if ($product->important)
                            <input type="checkbox" checked>
                        @else
                            <input type="checkbox">
                        @endif
                        <span class="slider round"></span>
                    </label>
                    <label class="switch">
                        @if ($product->enabled)
                            <input type="checkbox" checked>
                        @else
                            <input type="checkbox">
                        @endif
                        <span class="slider round"></span>
                    </label>
                    <label for="form-delete">Eliminar</label>
                    <input type="submit" value="GUARDAR" class="button button--blue introduction__button">
                </form>
            </div>
        </section>
    </main>
    @include('layouts.footer')
@endsection
