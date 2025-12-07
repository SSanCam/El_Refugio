{{-- resources/views/layouts/navigation.blade.php --}}

@php
    $mainRoute = auth()->user()->role === 'admin'
        ? 'admin.dashboard'
        : 'profile.edit';
@endphp

<div>
    <a href="{{ route($mainRoute) }}">
        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
    </a>
</div>

<div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
    <x-nav-link :href="route($mainRoute)" :active="request()->routeIs($mainRoute)">
        {{ auth()->user()->role === 'admin' ? 'Panel admin' : 'Mi área' }}
    </x-nav-link>
</div>
