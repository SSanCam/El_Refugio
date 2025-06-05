<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Apadrinamiento</title>
</head>
<body>
    <h1>Formulario de Apadrinamiento</h1>

    <form action="{{ route('sponsorship.submit') }}" method="POST">
        @csrf

        <input type="text" name="name" placeholder="Tu nombre completo" required><br><br>
        <input type="email" name="email" placeholder="Tu correo electrónico" required><br><br>
        <input type="tel" name="phone" placeholder="Tu número de teléfono (opcional)"><br><br>
        <input type="text" name="address" placeholder="Dirección (opcional)"><br><br>
        <input type="number" name="amount" placeholder="Cantidad mensual (€)" min="1" required><br><br>
        <textarea name="message" placeholder="Comentario opcional..."></textarea><br><br>

        <p>Recuerda que el apadrinamiento será mensual. Se te notificará por correo electrónico cuando el animal sea adoptado o fallezca.</p>

        <button type="submit">Iniciar apadrinamiento</button>
    </form>
</body>
</html>
