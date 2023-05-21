@extends('layouts.app')

@section('title', 'Tienda no encontrada')

@section('content')
    <div class="parent">
        @include('layouts.header')
        <section>
            <div class="error">
                <h1 class="error__code">404</h1>
                <h2>Lo sentimos, no hemos podido encontrar la tienda que buscas</h2>
                <a class="button button--blue introduction__button" href="{{ route('pages.landing') }}">VOLVER AL INICIO</a>
            </div>
            <div class="suggested">
                <h2>Echa un vistazo a estos productos</h2>
            </div>
            <div class="products">
                @foreach ($products as $product)
                    <article class="product-element">
                        <a href="{{ route('pages.product', [$product->id]) }}">
                            <img class="product-element__image" src="{{ $product->image }}">
                        </a>
                        <div class="product-element__info">
                            <h3 class="product-element__info-name">{{ $product->name }}</h3>
                            <span class="product-element__info-price">{{ $product->price }} €</span>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
        @include('layouts.footer')
    </div>
@endsection
