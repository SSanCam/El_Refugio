<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    </h1>Sponsorship Request</h1>

    <form action="{{ route('public.sponsorshipRequest.store') }}" method="POST">
        @csrf

        <!-- Campo oculto con ID del animal -->
        <input type="hidden" name="animal_id" value="{{ $animalId }}">

        <!-- Fecha de inicio -->
        <label for="start_date">Fecha de inicio</label>
        <input type="date" name="start_date" required>

        <!-- Fecha de fin (opcional) -->
        <label for="end_date">Fecha de finalización (opcional)</label>
        <input type="date" name="end_date">

        <!-- Cantidad de donación -->
        <label for="donation_amount">Cantidad a donar</label>
        <select name="donation_amount" required>
            <option value="">Selecciona una cantidad</option>
            <option value="1">1 €</option>
            <option value="10">10 €</option>
            <option value="20">20 €</option>
        </select>

        <!-- Intervalo de donación (bloqueado en mensual) -->
        <input type="hidden" name="donation_interval" value="mensual">

        <!-- Notas adicionales -->
        <label for="notes">Notas (opcional)</label>
        <textarea name="notes" maxlength="500"></textarea>

        <button type="submit">Confirmar apadrinamiento</button>
    </form>

</body>

</html>