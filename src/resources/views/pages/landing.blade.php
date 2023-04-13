@extends('layouts.app')

@section('title', 'Masterly')

@section('content')
    @include('layouts.header')
    <section class="introduction">
        <h1 class="introduction__title">MASTERLY</h1>
        <p class="introduction__text">Texto inspirador que Oscar se encargará de poner</p>
        <a class="button button--blue introduction__button" href="{{ route('pages.home') }}">COMPRA AHORA</a>
    </section>
    @foreach ($tags as $tag)
        <section class="tag">
            <div class="tag__title-container">
                <a class="tag__title" href="{{ route('pages.home', ['tagName' => $tag['id']]) }}">{{ $tag['id'] }}</a>
            </div>
            <div class="tag__products">
                @foreach ($tag['productsId'] as $product)
                    <div>
                        <article class="product-landing">
                            <a href="{{ route('pages.product', [$product[0]['id']]) }}">
                                <img class="product-element__image" src="{{ $product[0]['image'] }}">
                            </a>
                            <div class="product-element__info">
                                <div>
                                    <h3>{{ $product[0]['name'] }}</h3>
                                </div>
                                <div>
                                    <p>{{ $product[0]['price'] }}</p>
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
