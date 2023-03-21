@extends('layouts.app')

@section('title', 'Cart')

@section('content')
    <div class="parent">
        @include('layouts.header')
        <div class="cart">
            <section class="cart__header">
                <h2 class="cart__header-title">Carrito</h2>
                <h5 class="cart__header-products"><span></span> productos</h5>
                
            </section>
            <section class="cart__product-list">
                {{-- Product storage... --}}
            </section>
            <section class="cart__summary">
                <h3>Resumen:</h3>
                <div class="cart__summary-price">
                    <h4>Total:</h4>
                    <span></span>
                </div>
                <div class="button-container">
                    <button class="button button--blue"><span>Realizar pedido</span></button>
                    <a href="/home">    
                        <button class="button button--transparent"><span>Continuar comprando</span></button>
                    </a>
                </div>
            </section>
        </div>
        @include('layouts.footer')
    </div>
    <script src="{{ asset('js/productFetcher.js') }}"></script>
    <script src="{{ asset('js/storageListener.js') }}"></script>
@endsection