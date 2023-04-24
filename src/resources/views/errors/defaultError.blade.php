@extends('layouts.app')

@section('title', 'Error')

@section('content')
    <div class="parent">
        @include('layouts.header')
        <section>
            <div>
                <img src="{{ asset('images/error.png') }}">
            </div>
            <div>
                <h1>Ups, parece que ha habido un error en la página</h1>
            </div>
        </section>
        @include('layouts.footer')
    </div>
@endsection
