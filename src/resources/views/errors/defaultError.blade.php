@extends('layouts.app')

@section('title', 'Error')

@section('content')
    <div class="parent">
        @include('layouts.header')
        <section>
            <div>
                <img class="error__image" src="{{ asset('images/error.png') }}">
            </div>
            <div class="error__container">
                <div class="error__message">
                    <h1>Ups, parece que ha habido un error en la página</h1>
                </div>
                <a class="button button--blue introduction__button" href="{{ route('pages.landing') }}">VOLVER AL INICIO</a>
            </div>
        </section>
        @include('layouts.footer')
    </div>
@endsection
