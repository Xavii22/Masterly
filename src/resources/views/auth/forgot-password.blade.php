<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div>
        <label for="email">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required autofocus>
        @if ($errors->has('email'))
            <span>{{ $errors->first('email') }}</span>
        @endif
    </div>
    <div>
        <button type="submit">
            Enviar enlace para restablecer la contraseña
        </button>
    </div>
</form>
