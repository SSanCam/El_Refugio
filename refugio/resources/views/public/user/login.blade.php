{{-- resources/views/public/user/login.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="{{ asset('css/globalStyles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/loginRegistrer.css') }}">

</head>

<body>
    <div class="content">

        <div class="form-content">

            @if(session('success'))
            <p>{{ session('success') }}</p>
            @endif

            @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="form">
                <form method="POST" action="{{ route('public.user.login.authenticate') }}">
                    @csrf
                    <label>Email: <input type="email" name="email" value="{{ old('email') }}"></label><br>
                    <label>Contraseña: <input type="password" name="password"></label><br>
                    <label><input type="checkbox" name="remember"> Recordarme</label><br>
                    <div class="btn-login">
                        <button type="submit">Iniciar sesión</button>
                    </div>
                </form>

            </div>
            <div class="links">
                <a href="{{ route('public.user.register') }}">¿No tienes cuenta? Regístrate</a>
                @livewire('layout.home-page-button')
            </div>

        </div>
    </div>



</body>

</html>