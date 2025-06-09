<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/globalStyles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/loginRegistrer.css') }}">
</head>

<body>
    <div class="content">

        <div class="form-content">

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
                <form method="POST" action="{{ route('public.user.register.store') }}">
                    @csrf
                    <label>Nombre: <input type="text" name="name" value="{{ old('name') }}"></label><br>
                    <label>Email: <input type="email" name="email" value="{{ old('email') }}"></label><br>
                    <label>Contraseña: <input type="password" name="password"></label><br>
                    <label>Confirmar contraseña: <input type="password" name="password_confirmation"></label><br>
                    <div class="btn-register">
                        <button type="submit">Registrarse</button>
                        <span>¿Ya tienes cuenta? <a href="{{ route('public.user.login') }}">Inicia sesión</a></span>
                    </div>
                </form>
            </div>

            <div class="btn-inicio">
                @livewire('layout.home-page-button')
            </div>

        </div>
    </div>
</body>

</html>