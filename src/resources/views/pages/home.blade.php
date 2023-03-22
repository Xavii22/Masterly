@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="parent">
        @include('layouts.header')
        <div class="home">
            <aside class="categories">
                <div>
                    @if ($category != null)
                        <a href="{{ route('pages.home') }}">hola</a>
                        <span>/</span>
                        <a>{{ $categoryName }}</a>
                    @endif
                </div>
                <div class="categories__content">
                    <div class="categories__title">
                        <h2>Categorias</h2>
                    </div>
                    <div class="categories__list">
                        {{-- @if ($category != null) --}}
                        @foreach ($parentCategories as $parentCategory)
                            <a
                                href="{{ route('pages.home', ['query' => $query, 'sort' => 'recent', 'category' => $category]) }}">{{ $parentCategory->name }}</a>
                        @endforeach
                        {{-- @else --}}

                        {{-- @endif --}}

                    </div>
                </div>

            </aside>
            <section class="products-parent">
                <div class="products-title">
                    @if ($category != null)
                        <h1>{{ $categoryName }}</h1>
                    @else
                        <h1>Artículos</h1>
                    @endif
                </div>
                <div class="sort">
                    <a class="sort__link button button--transparent"
                        href="{{ route('pages.home', ['query' => $query, 'sort' => 'recent']) }}">Más reciente</a>
                    <a class="sort__link button button--transparent"
                        href="{{ route('pages.home', ['query' => $query, 'sort' => 'nameAsc']) }}">Nombre (A-Z)</a>
                    <a class="sort__link button button--transparent"
                        href="{{ route('pages.home', ['query' => $query, 'sort' => 'nameDesc']) }}">Nombre (Z-A)</a>
                    <a class="sort__link button button--transparent"
                        href="{{ route('pages.home', ['query' => $query, 'sort' => 'priceAsc']) }}">Precio más alto</a>
                    <a class="sort__link button button--transparent"
                        href="{{ route('pages.home', ['query' => $query, 'sort' => 'priceDesc']) }}">Precio más bajo</a>
                    <p>{{ $productAmount }}</p>
                </div>
                <div class="products">
                    @foreach ($products as $product)
                        <article class="product-element">
                            <a href="{{ route('pages.product', [$product->id]) }}">
                                <img class="product-element__image" src="{{ $product->image }}">
                            </a>
                            <img class="product-element__cart" src="{{ asset('images/cart.png') }}"
                                onclick="toggleProductInCart({{ $product->id }})">
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
                {{ $products->appends(['query' => $query, 'sort' => $sort])->links('vendor.pagination.default') }}
            </section>
        </div>
        @include('layouts.footer')
    </div>
    <script src="{{ asset('js/storageListener.js') }}"></script>
@endsection
