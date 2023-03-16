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
				<div class="sort">
                    <a class="sort__link button button--transparent" href="{{ route('search', ['query' => $query, 'sort' => 'asc']) }}">Más reciente</a>
                    <a class="sort__link button button--transparent" href="{{ route('search', ['query' => $query, 'sort' => 'asc']) }}">Nombre (A-Z)</a>
                    <a class="sort__link button button--transparent" href="{{ route('search', ['query' => $query, 'sort' => 'desc']) }}">Nombre (Z-A)</a>
                    <a class="sort__link button button--transparent" href="{{ route('search', ['query' => $query, 'sort' => 'desc']) }}">Precio más alto</a>
                    <a class="sort__link button button--transparent" href="{{ route('search', ['query' => $query, 'sort' => 'desc']) }}">Precio más bajo</a>
                </div>
                <div class="products">
                    @foreach ($products as $product)
                        <a href="{{route('pages.product', [$product->id])}}">
                            <article class="product-element">
                                <img class="product-element__image" src="{{ $product->image }}">
                                <div class="product-element__info">
                                    <div>
                                        <h3>{{ $product->name }}</h3>
                                    </div>
                                    <div>
                                        <p>{{ $product->price }}</p>
                                    </div>
                                </div>
                            </article>
                        </a>
                    @endforeach
                </div>
                {{ $products->appends(['query' => $query, 'sort' => $sort])->links('vendor.pagination.default') }}
            </section>
        </div>
        @include('layouts.footer')
    </div>
@endsection
