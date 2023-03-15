@extends('layouts.app')

@section('title', 'Home')

@section('content')
    @include('layouts.header')
    <div class="parent">
        <section class="categories">
            <div class="categories__title">
                <h2>Categorias</h2>
            </div>
        </section>
        <section class="products-parent">
            <div class="products-title">
                <h1>Artículos</h1>
            </div>
            <div class="sort">
                <div class="sort__content">
                    <a class="sort__link" href="{{ route('search', ['query' => $query, 'sort' => 'desc']) }}">Más reciente</a>
                    <a class="sort__link" href="{{ route('search', ['query' => $query, 'sort' => 'asc']) }}">Nombre (A-Z)</a>
                    <a class="sort__link" href="{{ route('search', ['query' => $query, 'sort' => 'desc']) }}">Nombre (Z-A)</a>
                    <a class="sort__link" href="{{ route('search', ['query' => $query, 'sort' => 'desc']) }}">Precio más alto</a>
                    <a class="sort__link" href="{{ route('search', ['query' => $query, 'sort' => 'desc']) }}">Precio más bajo</a>
                </div>
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
            {{ $products->appends(['query' => $query, 'sort' => $sort])->links('vendor.pagination.default') }}
        </section>
    </div>
    @include('layouts.footer')
@endsection
