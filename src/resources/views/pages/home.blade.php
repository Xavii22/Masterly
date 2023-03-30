@extends('layouts.app')

@section('title', 'Home')

@section('content')
    @include('layouts.header')
    <main>
        <div class="home">
            <section class="categories">
                <div class="categories__title">
                    <h2>Categoria</h2>
                </div>
            </section>
            <section class="products-parent">
                <div class="products-title">
                    <h1>Artículos</h1>
                </div>
                <div class="products">
                    @foreach ($products as $product)
                        <article class="product-element">
                            <a href="{{ route('pages.product', [$product->id]) }}">
                                <img class="product-element__image" src="{{ $product->image }}">
                            </a>
                            <img class="product-element__cart" id="{{ $product->id }}" src="{{ asset('images/cart.png') }}">
                            <div class="product-element__info">
                                <div>
                                    <h3>{{ $product->name }}</h3>
                                </div>
                                <div>
                                    <p>{{ $product->price }}</p>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                {{ $products->appends(['query' => $query])->links('vendor.pagination.default') }}
            </section>
        </div>
    </main>
    @include('layouts.footer')
    </div>
    <script src="{{ asset('js/storageListener.mjs') }}" type="module"></script>
@endsection
