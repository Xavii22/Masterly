<header class="header">
    <a class="item-link" href="{{ route('pages.landing') }}">
        <img class="header__logo" src="{{ asset('images/logo.png') }}" alt="Masterly">
    </a>
	<img class="header__logo header__logo--mobile" src="{{ asset('images/logo-mobile.png') }}" alt="Masterly">
    <div class="items">
        <form method="GET" action="{{ route('pages.home') }}">
            @csrf
            <input class="search-bar" type="text" name="query">
        </form>
        <a class="item-link" href="{{ route('pages.cart') }}">
            <img class="item" src="{{ asset('images/cart.png') }}" alt="Cart">
            <div class="stored-products"><span></span></div>
        </a>
        <a class="item-link" href="{{ route('pages.login') }}">
            <img class="item" src="{{ asset('images/user.png') }}" alt="User">
        </a>
        <a class="item-link item-link--hidden" href="">
            <img class="item" src="{{ asset('images/menu.png') }}" alt="Menu">
        </a>
    </div>
</header>
