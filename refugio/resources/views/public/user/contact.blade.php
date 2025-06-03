<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
</head>

<body>

    <div class="container">
        <h1>Contacto</h1>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('contact.send') }}">
            @csrf

            <div class="form-group">
                <label for="email">Tu correo electrónico:</label>
                <input type="email" id="email" name="email" required value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label for="message">Mensaje:</label>
                <textarea id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
            </div>

            <button type="submit">Enviar</button>
        </form>
    </div>

</body>

</html>
