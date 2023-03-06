<nav class="w3-bar w3-padding w3-card w3-margin-bottom">
    <a class="w3-bar-item w3-button" href="{{ route('home.index') }}">Laravel App</a>
    <div class="w3-right w3-hide-small">
        <a class="w3-bar-item w3-button" href="{{ route('home.index') }}">Home</a>
        <a class="w3-bar-item w3-button" href="{{ route('home.contact') }}">Contact</a>
        <a class="w3-bar-item w3-button" href="{{ route('posts.index') }}">Posts</a>
        <a class="w3-bar-item w3-button" href="{{ route('posts.create') }}">Add Post</a>

        @guest
            <a class="w3-bar-item w3-button" href="{{ route('auth.register') }}">Register</a>
            <a class="w3-bar-item w3-button" href="{{ route('auth.login') }}">Sign in</a>
        @else
            <a class="w3-bar-item w3-button" href="{{ route('auth.logout') }}">Sign out</a>
            <span class="w3-bar-item w3-blue">{{ auth()->user()->name }}</span>
        @endguest
    </div>
</nav>