@extends('layouts.app')

@section('title', 'Home')

@section('content')
    @include('layouts.header')
    <div class="parent">
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
                    <article class="product">
                        <img class="product__image" src="{{ $product->image }}">
                        <div class="product__info">
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
    @include('layouts.footer')
@endsection
