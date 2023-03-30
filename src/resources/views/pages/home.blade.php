@extends('layouts.app')

@section('title', 'Home')

@section('content')
    @include('layouts.header')
    <main>
        <div class="home">
            <aside class="categories">
                <div class="categories__path">
                    @if ($category != null && $childCategoryName == '')
                        <a href="{{ route('pages.home') }}">Inicio</a>
                        <span>/</span>
                        <a
                            href="{{ route('pages.home', ['query' => $query, 'category' => $category]) }}">{{ $parentCategoryName }}</a>
                    @elseif ($childCategoryName != '')
                        <a href="{{ route('pages.home') }}">Inicio</a>
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
                        @if ($childCategories != '')
                            <h2>Subcategorias</h2>
                        @else
                            <h2>Categorias</h2>
                        @endif
                    </div>
                    <div class="categories__list">
                        @if ($childCategories != '')
                            @foreach ($childCategories as $childCategory)
                                <div class="category">
                                    <a class="category__content category__text"
                                        href="{{ route('pages.home', ['query' => $query, 'sort' => 'recent', 'category' => $childCategory]) }}">{{ $childCategory->name }}</a>
                                    <img class="categories__icon category__content"
                                        src="{{ asset('images/right-arrow.png') }}">
                                </div>
                            @endforeach
                        @else
                            @foreach ($parentCategories as $parentCategory)
                                <div class="category">
                                    <a class="category__content category__text"
                                        href="{{ route('pages.home', ['query' => $query, 'sort' => 'recent', 'category' => $parentCategory]) }}">{{ $parentCategory->name }}</a>
                                    <img class="categories__icon category__content"
                                        src="{{ asset('images/right-arrow.png') }}">
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </aside>
            <section class="products-parent">
                @if ($products->total() > 0)
                    <div class="products-title">
                        @if ($childCategoryName != null)
                            <h1>{{ $childCategoryName }}</h1>
                        @elseif ($parentCategoryName != null)
                            <h1>{{ $parentCategoryName }}</h1>
                        @else
                            <h1>Artículos</h1>
                        @endif
                    </div>
                @endif

                @if ($products->total() > 0)
                    <div class="sort">
                        @if ($sort == 'recent')
                            <a class="sort__link sort__link--active button button--transparent"
                                href="{{ route('pages.home', ['query' => $query, 'sort' => 'recent', 'category' => $category]) }}">Más
                                reciente</a>
                        @else
                            <a class="sort__link button button--transparent"
                                href="{{ route('pages.home', ['query' => $query, 'sort' => 'recent', 'category' => $category]) }}">Más
                                reciente</a>
                        @endif
                        @if ($sort == 'nameAsc')
                            <a class="sort__link button sort__link--active button--transparent"
                                href="{{ route('pages.home', ['query' => $query, 'sort' => 'nameAsc', 'category' => $category]) }}">Nombre
                                (A-Z)</a>
                        @else
                            <a class="sort__link button button--transparent"
                                href="{{ route('pages.home', ['query' => $query, 'sort' => 'nameAsc', 'category' => $category]) }}">Nombre
                                (A-Z)</a>
                        @endif
                        @if ($sort == 'nameDesc')
                            <a class="sort__link button sort__link--active button--transparent"
                                href="{{ route('pages.home', ['query' => $query, 'sort' => 'nameDesc', 'category' => $category]) }}">Nombre
                                (Z-A)</a>
                        @else
                            <a class="sort__link button button--transparent"
                                href="{{ route('pages.home', ['query' => $query, 'sort' => 'nameDesc', 'category' => $category]) }}">Nombre
                                (Z-A)</a>
                        @endif
                        @if ($sort == 'priceAsc')
                            <a class="sort__link button sort__link--active button--transparent"
                                href="{{ route('pages.home', ['query' => $query, 'sort' => 'priceAsc', 'category' => $category]) }}">Precio
                                más alto</a>
                        @else
                            <a class="sort__link button button--transparent"
                                href="{{ route('pages.home', ['query' => $query, 'sort' => 'priceAsc', 'category' => $category]) }}">Precio
                                más alto</a>
                        @endif
                        @if ($sort == 'priceDesc')
                            <a class="sort__link button sort__link--active button--transparent"
                                href="{{ route('pages.home', ['query' => $query, 'sort' => 'priceDesc', 'category' => $category]) }}">Precio
                                más bajo</a>
                        @else
                            <a class="sort__link button button--transparent"
                                href="{{ route('pages.home', ['query' => $query, 'sort' => 'priceDesc', 'category' => $category]) }}">Precio
                                más bajo</a>
                        @endif
                        <p>{{ $products->total() }}</p>
                    </div>
                @endif
                <div class="products">
                    @if ($products->total() <= 0)
                        <h2>Ningún artículo corresponde a tu búsqueda</h2>
                    @endif
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
                {{ $products->appends(['query' => $query, 'sort' => $sort])->links('vendor.pagination.default') }}
            </section>
        </div>
    </main>
    @include('layouts.footer')
    </div>
    <script src="{{ asset('js/storageListener.mjs') }}" type="module"></script>
@endsection
