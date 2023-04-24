<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div>
        <label for="email">Correo electrónico</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus />
        @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>

    <div>
        <button type="submit">
            Enviar correo electrónico de restablecimiento de contraseña
        </button>
    </div>
</form>
