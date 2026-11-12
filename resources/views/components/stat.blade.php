@props(['label', 'value', 'hint' => null, 'icon' => null, 'tone' => 'slate'])

@php
    $tones = [
        'slate' => 'bg-slate-100 text-slate-600',
        'brand' => 'bg-brand-50 text-brand-700',
        'rose' => 'bg-rose-50 text-rose-600',
        'amber' => 'bg-amber-50 text-amber-700',
        'emerald' => 'bg-emerald-50 text-emerald-700',
    ];
@endphp

<div class="card p-4">
    <div class="flex items-start justify-between gap-3">
        <p class="text-sm text-slate-500">{{ $label }}</p>
        @if ($icon)
            <span class="grid size-8 place-items-center rounded-lg {{ $tones[$tone] ?? $tones['slate'] }}"><x-icon :name="$icon" class="size-4" /></span>
        @endif
    </div>
    <p class="mt-1 text-2xl font-semibold tracking-tight text-slate-900 tabular-nums">{{ $value }}</p>
    @if ($hint)
        <p class="mt-1 text-xs text-slate-500">{{ $hint }}</p>
    @endif
</div>
