@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="parent">
        @include('layouts.header')
        <div class="product">
            <section class="image">
                <div class="image__slider">
                    @php
                        $images = app('App\Http\Controllers\HomeController')->getImages($product->id);
                    @endphp
                    @foreach ($images as $image)
                        <img src="{{ $image }}" class="image__slider-image">
                    @endforeach
                    <div class="image__slider-buttons">
                        <img class="image__slider-left" src="{{ asset('images/arrow_image.png') }}" draggable="false"
                            onclick="plusDivs(+1)">
                        <img class="image__slider-right" src="{{ asset('images/arrow_image.png') }}" draggable="false"
                            onclick="plusDivs(-1)">
                    </div>
                </div>

            </section>
            <section class="content">
                <h1 class="content__title">{{ $product->name }}</h1>
                <h2 class="content__category">{{ $categoryName }} - {{ $subCategoryName }}</h2>
                <h3 class="content__price">{{ $product->price }}<span class="content__currency">€</span></h3>
                <h3 class="content__seller"><b>Vendedor: </b><a
                        href="{{ route('pages.store', [$storeNameInUrl]) }}">{{ $storeName }}</a></h3>
                <div class="buttons">
                    <button class="content__add-cart button button--grey cart-listener" id="{{ $product->id }}">
                        <img src="{{ asset('images/cart.png') }}" alt="Cart"><span>Añadir al carrito</span>
                    </button>
                    <button class="content__buy button button--blue">Comprar</button>
                </div>
            </section>
            <section class="details">
                <h2 class="details__title">Detalles del producto:</h2>
                <h3 class="details__description">{{ $product->description }}</h3>
            </section>
        </div>
        @include('layouts.footer')
    </div>
    <script src="{{ asset('js/storageListener.mjs') }}" type="module"></script>
    <script src="{{ asset('js/imageSlider.js') }}"></script>
@endsection
