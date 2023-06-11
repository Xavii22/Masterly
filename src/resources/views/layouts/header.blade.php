<?php

?>
<header class="header">
    <a class="item-link" href="{{ route('pages.landing') }}">
        <img class="header__logo" src="{{ asset('images/logo.png') }}" alt="Masterly">
        <img class="header__logo header__logo--mobile" src="{{ asset('images/logo-mobile.png') }}" alt="Masterly">
    </a>
    <div class="items">
        <form method="GET" action="{{ route('pages.home') }}">
            @csrf
            <input class="search-bar" type="text" name="query">
        </form>
        <a class="item-link" href="{{ route('pages.cart') }}">
            <img class="item" src="{{ asset('images/cart.png') }}" alt="Cart">
            <div class="stored-products">
                <span class="stored-products__number">-</span>
            </div>
        </a>
        @if (Auth::check())
            @php
                $controller = app(\App\Http\Controllers\HeaderController::class);
                $notificationNumber = $controller->checkUnreadChats();
            @endphp

            <a class="item-link" href="{{ route('pages.profile') }}">
            @else
                <a class="item-link" href="{{ route('pages.login') }}">
        @endif
        @if (Auth::check())
            @if (DB::table('users')->where('id', Auth::id())->value('pfp'))
                <img class="item" src="{{ asset(Auth::user()->pfp) }}" alt="User">
            @else
                {!! \App\Http\Controllers\HeaderController::userCircle(Auth::user()->name) !!}
            @endif
            @if ($notificationNumber > 0)
                <div class="item-link__notification">{{ $notificationNumber }}</div>
            @endif
        @else
            <img class="item" src="{{ asset('images/user.png') }}" alt="User">
        @endif
        </a>
    </div>
</header>
