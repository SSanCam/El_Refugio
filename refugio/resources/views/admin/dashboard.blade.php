<!-- resources/views/admin/dashboard.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
</head>
<body>
    <h1>Bienvenida al Panel de Administración</h1>

    <p>Has iniciado sesión como administradora.</p>

    <ul>
        <li><a href="{{ route('admin.user.index') }}">Gestionar Usuarios</a></li>
        <li><a href="{{ route('admin.animal.index') }}">Gestionar Animales</a></li>
        <li><a href="{{ route('admin.adoption.index') }}">Gestionar Adopciones</a></li>
        <li><a href="{{ route('admin.foster.index') }}">Gestionar Acogidas</a></li>
    </ul>
</body>
</html>
