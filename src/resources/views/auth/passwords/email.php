<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div>
        <label for="email">{{ __('E-Mail Address') }}</label>

        <div>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>

            @error('email')
                <span role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div>
        <div>
            <button type="submit">
                {{ __('Send Password Reset Link') }}
            </button>
        </div>
    </div>
</form>