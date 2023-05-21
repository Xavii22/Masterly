@extends('layouts.app')

@section('title', 'Store')

@section('content')
    @include('layouts.header')
    <main>
        <div class="home">
            <section class="products-parent">
                @if ($products->total() > 0 || $importantProducts->total() > 0)
                    <div class="products-title">
                        <div class="products-title__image">
                            <img class="products-title__image" src="{{ asset($storeLogo) }}">
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
                    {{-- <a href="" class="button button--blue dropdown__button">CREAR PRODUCTO</a> --}}
                    {{-- <button class="button button--blue dropdown__button">DALTONISMO</button>
                    <div class="dropdown__content">
                        <span class="dropdown-content__value">Protanopia</span>
                        <span class="dropdown-content__value">Deuteranopia</span>
                        <span class="dropdown-content__value">Acromatopsia</span>
                        <span class="dropdown-content__value">Tritanopia</span>
                    </div> --}}
                </div>
                @if ($products->total() <= 0 && $importantProducts->total() <= 0)
                    <h2>Esta tienda no tiene ningún producto</h2>
                @endif
                @if ($importantProducts->total() > 0)
                    <h2 class="product-featured">Artículos destacados</h2>
                    <div class="products">
                        @foreach ($importantProducts as $importantProduct)
                            <article class="product-element">
                                @if (Route::currentRouteName() == 'pages.manageStore')
                                    <a href="{{ route('pages.editProduct', [$importantProduct->id]) }}"><img class="product-element__cart" src="{{ asset('images/edit.png') }}"></a>
                                @endif
                                @php
                                    $mainImage = app('App\Http\Controllers\HomeController')->getMainImage($importantProduct->id);
                                @endphp
                                <a href="{{ route('pages.product', [$importantProduct->id]) }}">
                                    <img class="product-element__image" src="{{ $mainImage }}">
                                </a>
                                <div class="product-element__info">
                                    <h3 class="product-element__info-name">{{ $importantProduct->name }}</h3>
                                    <span class="product-element__info-price">{{ $importantProduct->price }} €</span>
                                    <span class="product-element__info-category">{{ $importantProduct->name }}</span>
                                    @if (Route::currentRouteName() != 'pages.manageStore')
                                        <img class="product-element__cart cart-listener" id="{{ $importantProduct->id }}"
                                            src="{{ asset('images/cart.png') }}">
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
                <div class="products">

                    @foreach ($products as $product)
                        <article class="product-element">
                            @if (Route::currentRouteName() == 'pages.manageStore')
                                <a href="{{ route('pages.editProduct', [$product->id]) }}"><img class="product-element__cart" src="{{ asset('images/edit.png') }}"></a>
                            @endif
                            @php
                                $mainImage = app('App\Http\Controllers\HomeController')->getMainImage($product->id);
                                $productSubcategory = $product->categories()->value('name');
                            @endphp
                            <a href="{{ route('pages.product', [$product->id]) }}">
                                <img class="product-element__image" src="{{ $mainImage }}">
                            </a>
                            <div class="product-element__info">
                                <h3 class="product-element__info-name">{{ $product->name }}</h3>
                                <span class="product-element__info-price">{{ $product->price }} €</span>
                                <span class="product-element__info-category">{{ $productSubcategory }}</span>
                                @if (Route::currentRouteName() != 'pages.manageStore')
                                    <img class="product-element__cart cart-listener" id="{{ $product->id }}"
                                        src="{{ asset('images/cart.png') }}">
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
                {{ $products->appends(['query' => $query, 'sort' => $sort])->links('vendor.pagination.default') }}
            </section>
            @if (Route::currentRouteName() == 'pages.manageStore')
                <a class="add-product" href="{{ route('pages.createProduct') }}">
                    <img class="add_product" src="{{ asset('images/add_product.png') }}">
                </a>
            @endif
        </div>
    </main>
    @include('layouts.footer')
    </div>
    <script src="{{ asset('js/storageListener.mjs') }}" type="module"></script>
    <script src="{{ asset('js/categoryLink.js') }}"></script>
    <script src="{{ asset('js/colorblindnessFilter.js') }}"></script>
@endsection
