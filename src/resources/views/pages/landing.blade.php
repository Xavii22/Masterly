@extends('layouts.app')

@section('title', 'Los mejores productes artesanales')

@section('content')
    @include('layouts.header')
    <section class="introduction">
        <h1 class="introduction__title">MASTERLY</h1>
        <div class="introduction__container">
            <p class="introduction__text">Los mejores productos artesanales</p>
        </div>
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
