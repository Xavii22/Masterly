@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="parent">
        @include('layouts.header')
        <div class="product">
            <section class="image">
                <img src="" alt="">
            </section>
            <section class="content">
                <h1>jjj</h1>
                <h2></h2>
                <h3></h3>
            </section>
            <section class="description"></section>
        </div>
        @include('layouts.footer')
    </div>
@endsection
