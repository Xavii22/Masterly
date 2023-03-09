@extends('layouts.app')

@section('title', 'Home')

@section('content')
    @include('layouts.header')
    <div class="containerf">
        <section class="containerh">

        </section>
        <section class="containerg">
            @foreach ($products as $product)
                <article class="containerq">
                    <img src="{{ $product->image }}" class="image-product">
                    <div class="flex-cont">
                        <div>
                            <h3>{{ $product->name }}</h3>
                        </div>
                        <div>
                            <p>{{ $product->price }}</p>
                        </div>
                    </div>
                </article>
            @endforeach
        </section>
    </div>
    @include('layouts.footer')
@endsection
