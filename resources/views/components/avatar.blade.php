@props(['initials', 'size' => 'size-8'])

<span {{ $attributes->merge(['class' => "grid shrink-0 place-items-center rounded-full bg-brand-100 text-xs font-semibold text-brand-700 $size"]) }}>{{ $initials }}</span>
