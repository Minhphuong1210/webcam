@props(['sla'])

@php
    $styles = [
        'ok' => 'text-emerald-700',
        'warn' => 'text-amber-700',
        'late' => 'text-rose-700 font-semibold',
        'info' => 'text-slate-500',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex min-w-0 items-center gap-1 whitespace-nowrap text-xs leading-tight '.($styles[$sla['state']] ?? $styles['info'])]) }}>
    <x-icon :name="$sla['state'] === 'late' ? 'alert' : 'clock'" class="size-3.5 shrink-0" />
    {{ $sla['label'] }}
</span>
