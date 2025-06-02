<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Nueva Acogida</title>
</head>

<body>

    <h1>Registrar nueva acogida</h1>

    @if($errors->any())
    <div style="color:red;">
        <strong>Se han producido errores:</strong>
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.fosters.store') }}" method="POST">
        @csrf

        <!-- Animal a acoger -->
        <div>
            <label for="animal_id">Animal:</label>
            <select name="animal_id" id="animal_id" required>
                <option value="">-- Selecciona un animal --</option>
                @foreach($animals as $animal)
                <option value="{{ $animal->id }}">{{ $animal->name }}</option>
                @endforeach
            </select>
        </div>

        <hr>

        <!-- Email del acogedor -->
        <div>
            <label for="email">Correo del usuario que acoge:</label>
            <input type="email" name="email" id="email" required>
            <small>Si el usuario ya está registrado, se usarán sus datos.</small>
        </div>

        <!-- Datos del acogedor (opcional, por si no existe) -->
        <div>
            <label for="name">Nombre completo:</label>
            <input type="text" name="name" id="name">
        </div>

        <div>
            <label for="phone">Teléfono:</label>
            <input type="text" name="phone" id="phone">
        </div>

        <!-- Fechas de acogida -->
        <hr>
        <div>
            <label for="start_date">Fecha de inicio:</label>
            <input type="date" name="start_date" id="start_date" required>
        </div>

        <div>
            <label for="end_date">Fecha estimada de fin (opcional):</label>
            <input type="date" name="end_date" id="end_date">
        </div>

        <!-- Estado de la acogida -->
        <div>
            <label for="status">Estado:</label>
            <select name="status" id="status" required>
                <option value="pending">Pendiente</option>
                <option value="fostering">En curso</option>
                <option value="finished">Finalizada</option>
            </select>
        </div>

        <button type="submit">Guardar acogida</button>
        <a href="{{ route('admin.fosters.index') }}">Cancelar</a>
    </form>

</body>

</html>