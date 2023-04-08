@extends('layouts.app')

@section('title', 'Masterly')

@section('content')
    @include('layouts.header')
    <h1>Landing page</h1>
    @foreach ($tags as $tag)
        <section class="tag">
            <h2>{{ $tag['name'] }}</h2>
            @foreach ($tag['productsId'] as $product)
                <div class="tag__products">
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
        </section>
    @endforeach
    @include('layouts.footer')
@endsection
