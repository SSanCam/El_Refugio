<form method="POST" action="{{ route('admin.adoptions.store') }}">
    @csrf

    <label for="animal_id">Animal:</label>
    <select name="animal_id" required>
        @foreach ($animals as $animal)
            <option value="{{ $animal->id }}">{{ $animal->name }}</option>
        @endforeach
    </select>

    <label for="user_id">Usuario:</label>
    <select name="user_id" required>
        @foreach ($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
        @endforeach
    </select>

    <label for="adoption_date">Fecha de adopción:</label>
    <input type="date" name="adoption_date" required>

    <label for="notes">Notas:</label>
    <textarea name="notes"></textarea>

    <button type="submit">Registrar adopción</button>
</form>
