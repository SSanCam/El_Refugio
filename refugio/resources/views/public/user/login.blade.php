@section('content')
<div class="container">
    <h2>Iniciar sesión</h2>

    {{-- Mensajes de error --}}
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Mensaje de éxito --}}
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email">Correo electrónico</label>
            <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required
                autofocus>
        </div>

        <div class="mb-3">
            <label for="password">Contraseña</label>
            <input id="password" type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="remember" id="remember" class="form-check-input">
            <label class="form-check-label" for="remember">Recuérdame</label>
        </div>

        <button type="submit" class="btn btn-primary">Iniciar sesión</button>

        <p class="mt-3">
            ¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a>
        </p>
    </form>
</div>
@endsection