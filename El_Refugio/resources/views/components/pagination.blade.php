@props([
    'currentPage' => 1,
    'lastPage' => 1,
])

@if ($lastPage > 1)
<nav class="pagination-wrapper">

    {{-- Solo desktop (numeración) --}}
    <div class="flex items-center justify-center gap-2 mt-4">

        {{-- Page numbers --}}
        @for ($page = 1; $page <= $lastPage; $page++)
            @if ($page == $currentPage)
                <span class="px-3 py-1 font-bold underline">{{ $page }}</span>
            @else
                <a href="{{ request()->fullUrlWithQuery(['page' => $page]) }}"
                   class="px-3 py-1 hover:text-gray-600">
                    {{ $page }}
                </a>
            @endif
        @endfor

    </div>

</nav>
@endif
