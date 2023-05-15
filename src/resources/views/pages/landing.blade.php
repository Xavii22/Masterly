@extends('layouts.app')

@section('title', 'Masterly')

@section('content')
    @include('layouts.header')
    <section class="introduction">
        <h1 class="introduction__title">MASTERLY</h1>
        <p class="introduction__text">Mensaje inspirador que Oscar se encargará de poner</p>
        <a class="button button--blue introduction__button" href="{{ route('pages.home') }}">COMPRA AHORA</a>
    </section>
    @foreach ($tags as $tag)
        <section class="tag">
            <div class="tag__title-container">
                <a class="tag__title" href="{{ route('pages.home', ['tagName' => $tag['id']]) }}">{{ $tag['name'] }}</a>
            </div>
            <div class="tag__products">
                @foreach ($tag['products'] as $product)
                    @php
                        $mainImage = app('App\Http\Controllers\HomeController')->getMainImage($product->id);
                    @endphp
                    <div>
                        <article class="product-landing">
                            <a href="{{ route('pages.product', [$product['id']]) }}">
                                <img class="product-element__image" src="{{ $mainImage }}">
                            </a>
                            <div class="product-element__info">
                                <div>
                                    <h3>{{ $product['name'] }}</h3>
                                </div>
                                <div>
                                    <p>{{ $product['price'] }}</p>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </section>
    @endforeach
    @include('layouts.footer')
@endsection
