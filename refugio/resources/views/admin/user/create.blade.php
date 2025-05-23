<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creación usuarios</title>
    @livewireStyles
</head>

<body>
    <h1>Usuario: {{ $user->name }}</h1>
    <p>Email: {{ $user->email }}</p>

    @livewire('admin.actions-for-user', ['userId' => $user->id])

    @livewireScripts
</body>

</html>