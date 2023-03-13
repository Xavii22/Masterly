@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="parent">
        @include('layouts.header')
        <div class="product">
            <section class="image">
                <img src="https://i.ebayimg.com/images/g/9nkAAMXQI5tRiccx/s-l500.jpg" alt="">
            </section>
            <section class="content">
                <h1 class="content__title">Gaviola de juguete para niños</h1>
                <h2 class="content__category">Categoria - Subcategoria</h2>
                <h3 class="content__price">50€</h3>
            </section>
            <section class="details">
                <h2 class="details__title"></h2>
                <h2 class="details__description"></h2>
            </section>
        </div>
        @include('layouts.footer')
    </div>
@endsection
