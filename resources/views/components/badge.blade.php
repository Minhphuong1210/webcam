@props(['color' => 'slate', 'dot' => false])

@php
    $palette = [
        'slate' => 'bg-slate-100 text-slate-700 ring-slate-200',
        'brand' => 'bg-brand-50 text-brand-700 ring-brand-200',
        'amber' => 'bg-amber-50 text-amber-800 ring-amber-200',
        'orange' => 'bg-orange-50 text-orange-800 ring-orange-200',
        'sky' => 'bg-sky-50 text-sky-800 ring-sky-200',
        'violet' => 'bg-violet-50 text-violet-800 ring-violet-200',
        'blue' => 'bg-blue-50 text-blue-800 ring-blue-200',
        'teal' => 'bg-teal-50 text-teal-800 ring-teal-200',
        'emerald' => 'bg-emerald-50 text-emerald-800 ring-emerald-200',
        'rose' => 'bg-rose-50 text-rose-700 ring-rose-200',
        'fuchsia' => 'bg-fuchsia-50 text-fuchsia-800 ring-fuchsia-200',
    ];
    $dots = [
        'slate' => 'bg-slate-400', 'brand' => 'bg-brand-500', 'amber' => 'bg-amber-500', 'orange' => 'bg-orange-500', 'sky' => 'bg-sky-500',
        'violet' => 'bg-violet-500', 'blue' => 'bg-blue-500', 'teal' => 'bg-teal-500', 'emerald' => 'bg-emerald-500',
        'rose' => 'bg-rose-500', 'fuchsia' => 'bg-fuchsia-500',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-1.5 whitespace-nowrap rounded-full px-2 py-0.5 text-xs font-medium ring-1 ring-inset '.($palette[$color] ?? $palette['slate'])]) }}>
    @if ($dot)
        <span class="size-1.5 rounded-full {{ $dots[$color] ?? $dots['slate'] }}"></span>
    @endif
    {{ $slot }}
</span>
