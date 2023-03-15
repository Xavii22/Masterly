<header class="header">
    <a href="{{ route('pages.home') }}">
        <img class="header__logo" src="{{ asset('images/logo.png') }}" alt="Masterly">
    </a>
	<img class="header__logo header__logo--mobile" src="{{ asset('images/logo-mobile.png') }}" alt="Masterly">
    <div class="items">
        <form method="GET" action="{{ route('search') }}">
            @csrf
            <input class="search-bar" type="text" name="query">
        </form>
        <img class="item" src="{{ asset('images/cart.png') }}" alt="Cart">
        <a class="login-link" href="{{ route('pages.login') }}">
            <img class="item" src="{{ asset('images/user.png') }}" alt="User">
        </a>
    </div>
</header>
