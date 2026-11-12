@props(['title', 'subtitle' => null])

<div class="flex items-center justify-between gap-3 border-b border-slate-100 px-4 py-3">
    <div>
        <h2 class="text-sm font-semibold text-slate-900">{{ $title }}</h2>
        @if ($subtitle)
            <p class="text-xs text-slate-500">{{ $subtitle }}</p>
        @endif
    </div>
    {{ $slot }}
</div>
