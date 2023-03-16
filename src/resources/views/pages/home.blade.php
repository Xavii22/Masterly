@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="parent">
        @include('layouts.header')
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
                            {{-- <a href="{{ route('pages.product', [$product->id]) }}"> --}}
                                <img class="product-element__image" src="{{ $product->image }}">
                                <img class="product-element__cart" src="{{ asset('images/cart.png') }}" onclick="storeProduct({{ $product->id }})">
                                <div class="product-element__info">
                                    <div>
                                        <h3>{{ $product->name }}</h3>
                                    </div>
                                    <div>
                                        <p>{{ $product->price }}</p>
                                    </div>
                                </div>
                            {{-- </a> --}}
                        </article>
                    @endforeach
                </div>
                {{ $products->appends(['query' => $query])->links('vendor.pagination.default') }}
            </section>
        </div>
        @include('layouts.footer')
    </div>
    <script src="{{ asset('js/ProductStorage.js') }}"></script>
@endsection
