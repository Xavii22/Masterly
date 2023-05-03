@extends('layouts.app')

@section('title', 'Store')

@section('content')
    @include('layouts.header')
    <main>
        <div class="home">
            <aside class="categories">
                <div class="categories__path">
                    @if ($category != null && $childCategoryName == '')
                        <a href="{{ route('pages.store', ['id' => $id]) }}">Inicio</a>
                        <span>/</span>
                        <a
                            href="{{ route('pages.store', ['id' => $id, 'query' => $query, 'category' => $category]) }}">{{ $parentCategoryName }}</a>
                    @elseif ($childCategoryName != '')
                        <a href="{{ route('pages.store', ['id' => $id]) }}">Inicio</a>
                        <span>/</span>
                        <a
                            href="{{ route('pages.store', ['id' => $id, 'query' => $query, 'category' => $parentCategory]) }}">{{ $parentCategoryName }}</a>
                        <span>/</span>
                        <a
                            href="{{ route('pages.store', ['id' => $id, 'query' => $query, 'category' => $category]) }}">{{ $childCategoryName }}</a>
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
                                        href="{{ route('pages.store', ['id' => $id, 'query' => $query, 'sort' => 'recent', 'category' => $childCategory]) }}">{{ $childCategory->name }}</a>
                                    <img class="categories__icon category__content"
                                        src="{{ asset('images/right-arrow.png') }}">
                                </div>
                            @endforeach
                        @else
                            @foreach ($parentCategories as $parentCategory)
                                <div class="category">
                                    <a class="category__content category__text"
                                        href="{{ route('pages.store', ['id' => $id, 'query' => $query, 'sort' => 'recent', 'category' => $parentCategory]) }}">{{ $parentCategory->name }}</a>
                                    <img class="categories__icon category__content"
                                        src="{{ asset('images/right-arrow.png') }}">
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </aside>
            <section class="products-parent">
                @if ($products->total() > 0 || $importantProducts->total() > 0)
                    <div class="products-title">
                        <div class="products-title__image">
                            <img class="products-title__image" src="{{ asset('images/logo-mobile.png') }}">
                        </div>
                        @if ($childCategoryName != null)
                            <h1>{{ $currentStoreName }} - {{ $childCategoryName }}</h1>
                        @elseif ($parentCategoryName != null)
                            <h1>{{ $currentStoreName }} - {{ $parentCategoryName }}</h1>
                        @else
                            <h1>{{ $currentStoreName }} - Artículos</h1>
                        @endif
                    </div>
                @endif
                <div class="products-total">
                    <span class="products-total__number">{{ $products->total() + $importantProducts->total() }}
                        artículos</span>
                </div>
                @if ($products->total() > 0 || $importantProducts->total() > 0)
                    <div class="sort">
                        @if ($sort == 'recent')
                            <a class="sort__link sort__link--active button button--transparent"
                                href="{{ route('pages.store', ['id' => $id, 'query' => $query, 'sort' => 'recent', 'category' => $category, 'tagName' => $tagName]) }}">Más
                                reciente</a>
                        @else
                            <a class="sort__link button button--transparent"
                                href="{{ route('pages.store', ['id' => $id, 'query' => $query, 'sort' => 'recent', 'category' => $category, 'tagName' => $tagName]) }}">Más
                                reciente</a>
                        @endif
                        @if ($sort == 'nameAsc')
                            <a class="sort__link button sort__link--active button--transparent"
                                href="{{ route('pages.store', ['id' => $id, 'query' => $query, 'sort' => 'nameAsc', 'category' => $category, 'tagName' => $tagName]) }}">Nombre
                                (A-Z)</a>
                        @else
                            <a class="sort__link button button--transparent"
                                href="{{ route('pages.store', ['id' => $id, 'query' => $query, 'sort' => 'nameAsc', 'category' => $category, 'tagName' => $tagName]) }}">Nombre
                                (A-Z)</a>
                        @endif
                        @if ($sort == 'nameDesc')
                            <a class="sort__link button sort__link--active button--transparent"
                                href="{{ route('pages.store', ['id' => $id, 'query' => $query, 'sort' => 'nameDesc', 'category' => $category, 'tagName' => $tagName]) }}">Nombre
                                (Z-A)</a>
                        @else
                            <a class="sort__link button button--transparent"
                                href="{{ route('pages.store', ['id' => $id, 'query' => $query, 'sort' => 'nameDesc', 'category' => $category, 'tagName' => $tagName]) }}">Nombre
                                (Z-A)</a>
                        @endif
                        @if ($sort == 'priceAsc')
                            <a class="sort__link button sort__link--active button--transparent"
                                href="{{ route('pages.store', ['id' => $id, 'query' => $query, 'sort' => 'priceAsc', 'category' => $category, 'tagName' => $tagName]) }}">Precio
                                más alto</a>
                        @else
                            <a class="sort__link button button--transparent"
                                href="{{ route('pages.store', ['id' => $id, 'query' => $query, 'sort' => 'priceAsc', 'category' => $category, 'tagName' => $tagName]) }}">Precio
                                más alto</a>
                        @endif
                        @if ($sort == 'priceDesc')
                            <a class="sort__link button sort__link--active button--transparent"
                                href="{{ route('pages.store', ['id' => $id, 'query' => $query, 'sort' => 'priceDesc', 'category' => $category, 'tagName' => $tagName]) }}">Precio
                                más bajo</a>
                        @else
                            <a class="sort__link button button--transparent"
                                href="{{ route('pages.store', ['id' => $id, 'query' => $query, 'sort' => 'priceDesc', 'category' => $category, 'tagName' => $tagName]) }}">Precio
                                más bajo</a>
                        @endif
                    </div>
                @endif
                <div class="dropdown">
                    <button class="button button--blue dropdown__button">DALTONISMO</button>
                    <div class="dropdown__content">
                        <span class="dropdown-content__value">Protanopia</span>
                        <span class="dropdown-content__value">Deuteranopia</span>
                        <span class="dropdown-content__value">Acromatopsia</span>
                        <span class="dropdown-content__value">Tritanopia</span>
                    </div>
                </div>
                @if ($products->total() <= 0 && $importantProducts->total() <= 0)
                    <h2>Ningún artículo corresponde a tu búsqueda</h2>ºº
                @endif
                @if ($importantProducts->total() > 0)
                    <h2>Artículos destacados</h2>
                    <div class="products">
                        @foreach ($importantProducts as $importantProduct)
                            <article class="product-element">
                                @if (Route::currentRouteName() == 'pages.manageStore')
                                    <a href="{{ route('pages.editProduct', [$importantProduct->id]) }}">editar</a>
                                @endif
                                <a href="{{ route('pages.product', [$importantProduct->id]) }}">
                                    <img class="product-element__image" src="{{ $importantProduct->image }}">
                                </a>
                                <div class="product-element__info">
                                    <h3 class="product-element__info-name">{{ $importantProduct->name }}</h3>
                                    <span class="product-element__info-price">{{ $importantProduct->price }} €</span>
                                    <span class="product-element__info-category">{{ $importantProduct->name }}</span>
                                    <img class="product-element__cart cart-listener" id="{{ $importantProduct->id }}"
                                        src="{{ asset('images/cart.png') }}">
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
                <div class="products">

                    @foreach ($products as $product)
                        <article class="product-element">
                            @if (Route::currentRouteName() == 'pages.manageStore')
                                <a href="{{ route('pages.editProduct', [$importantProduct->id]) }}">editar</a>
                            @endif
                            <a href="{{ route('pages.product', [$product->id]) }}">
                                <img class="product-element__image" src="{{ $product->image }}">
                            </a>
                            <div class="product-element__info">
                                <h3 class="product-element__info-name">{{ $product->name }}</h3>
                                <span class="product-element__info-price">{{ $product->price }} €</span>
                                <span class="product-element__info-category">{{ $product->name }}</span>
                                <img class="product-element__cart cart-listener" id="{{ $product->id }}"
                                    src="{{ asset('images/cart.png') }}">
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
    <script src="{{ asset('js/categoryLink.js') }}"></script>
    <script src="{{ asset('js/colorblindnessFilter.js') }}"></script>
@endsection
