<header class="header">
    <a class="item-link" href="{{ route('pages.home') }}">
        <img class="header__logo" src="{{ asset('images/logo.png') }}" alt="Masterly">
    </a>
    <div class="items">
        <form method="GET" action="{{ route('search') }}">
            @csrf
            <input class="search-bar" type="text" name="query">
        </form>
        <a class="item-link" href="{{ route('pages.cart') }}">
            <img class="item" src="{{ asset('images/cart.png') }}" alt="Cart">
            <div class="stored-products"><span>3</span></div>
        </a>
        <a class="item-link" href="{{ route('pages.login') }}">
            <img class="item" src="{{ asset('images/user.png') }}" alt="User">
        </a>
    </div>
</header>
