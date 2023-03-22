@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="parent">
        @include('layouts.header')
        <div class="home">
            <aside class="categories">
                <div>
                    @if ($category != null && $childCategoryName == '')
                        <a href="{{ route('pages.home') }}">hola</a>
                        <span>/</span>
                        <a
                            href="{{ route('pages.home', ['query' => $query, 'category' => $category]) }}">{{ $parentCategoryName }}</a>
                    @elseif ($childCategoryName != '')
                        <a href="{{ route('pages.home') }}">hola</a>
                        <span>/</span>
                        <a
                            href="{{ route('pages.home', ['query' => $query, 'category' => $parentCategory]) }}">{{ $parentCategoryName }}</a>
                        <span>/</span>
                        <a
                            href="{{ route('pages.home', ['query' => $query, 'category' => $category]) }}">{{ $childCategoryName }}</a>
                    @endif
                </div>
                <div class="categories__content">
                    <div class="categories__title">
                        <h2>Categorias</h2>
                    </div>
                    <div class="categories__list">
                        @if ($childCategories != '')
                            @foreach ($childCategories as $childCategory)
                                <a
                                    href="{{ route('pages.home', ['query' => $query, 'sort' => 'recent', 'category' => $childCategory]) }}">{{ $childCategory->name }}</a>
                            @endforeach
                        @else
                            @foreach ($parentCategories as $parentCategory)
                                <a
                                    href="{{ route('pages.home', ['query' => $query, 'sort' => 'recent', 'category' => $parentCategory]) }}">{{ $parentCategory->name }}</a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </aside>
            <section class="products-parent">
                <div class="products-title">
                    @if ($category != null)
                        <h1>{{ $parentCategoryName }}</h1>
                    @else
                        <h1>Artículos</h1>
                    @endif
                </div>
                <div class="sort">
                    <a class="sort__link button button--transparent"
                        href="{{ route('pages.home', ['query' => $query, 'sort' => 'recent', 'category' => $category]) }}">Más
                        reciente</a>
                    <a class="sort__link button button--transparent"
                        href="{{ route('pages.home', ['query' => $query, 'sort' => 'nameAsc', 'category' => $category]) }}">Nombre
                        (A-Z)</a>
                    <a class="sort__link button button--transparent"
                        href="{{ route('pages.home', ['query' => $query, 'sort' => 'nameDesc', 'category' => $category]) }}">Nombre
                        (Z-A)</a>
                    <a class="sort__link button button--transparent"
                        href="{{ route('pages.home', ['query' => $query, 'sort' => 'priceAsc', 'category' => $category]) }}">Precio
                        más alto</a>
                    <a class="sort__link button button--transparent"
                        href="{{ route('pages.home', ['query' => $query, 'sort' => 'priceDesc', 'category' => $category]) }}">Precio
                        más bajo</a>
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
