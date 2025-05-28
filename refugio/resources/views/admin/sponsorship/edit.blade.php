<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Editar un apadrinamiento</h1>

    <h1>Editar Apadrinamiento #{{ $sponsorship->id }}</h1>

    @if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.sponsorships.update', $sponsorship->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Email:</label>
        <input type="email" name="email" value="{{ old('email', $sponsorship->email) }}" required>

        <label>Estado:</label>
        <select name="status" required>
            @foreach(\App\Enums\SponsorshipStatus::cases() as $status)
            <option value="{{ $status->value }}" {{ $sponsorship->status === $status->value ? 'selected' : '' }}>
                {{ $status->label() }}
            </option>
            @endforeach
        </select>

        <label>Fecha de inicio:</label>
        <input type="date" name="start_date" value="{{ old('start_date', $sponsorship->start_date->format('Y-m-d')) }}"
            required>

        <label>Fecha de fin:</label>
        <input type="date" name="end_date"
            value="{{ old('end_date', optional($sponsorship->end_date)->format('Y-m-d')) }}">

        <label>Cantidad donada (€):</label>
        <input type="number" step="0.01" name="donation_amount"
            value="{{ old('donation_amount', $sponsorship->donation_amount) }}" required min="0">

        <label>Intervalo de donación:</label>
        <input type="text" name="donation_interval"
            value="{{ old('donation_interval', $sponsorship->donation_interval) }}" required>

        <label>Notas:</label>
        <textarea name="notes">{{ old('notes', $sponsorship->notes) }}</textarea>

        <button type="submit">Guardar Cambios</button>
    </form>

    <a href="{{ route('admin.sponsorships.index') }}">Volver a la lista</a>

</body>

</html>