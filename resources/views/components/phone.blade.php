@props(['caption', 'step' => null, 'offline' => false])

<figure class="flex flex-col items-center">
    <div class="relative w-[300px] rounded-[2.6rem] bg-ink-900 p-2.5 shadow-xl ring-1 ring-slate-900/10">
        <div class="relative flex h-[610px] flex-col overflow-hidden rounded-[2.1rem] bg-slate-50">
            <div class="flex h-9 shrink-0 items-center justify-between px-6 pt-1 text-[11px] font-semibold text-slate-800">
                <span>10:24</span>
                <span class="absolute top-2 left-1/2 h-5 w-20 -translate-x-1/2 rounded-full bg-ink-900"></span>
                <span class="flex items-center gap-1">
                    @if ($offline)
                        <x-icon name="wifi-off" class="size-3.5 text-orange-600" />
                    @else
                        <span class="flex items-end gap-px"><span class="h-1 w-0.5 bg-slate-800"></span><span class="h-1.5 w-0.5 bg-slate-800"></span><span class="h-2 w-0.5 bg-slate-800"></span><span class="h-2.5 w-0.5 bg-slate-800"></span></span>
                    @endif
                    <span class="h-2.5 w-5 rounded-sm border border-slate-800 p-px"><span class="block h-full w-3/4 rounded-[1px] bg-slate-800"></span></span>
                </span>
            </div>
            @if ($offline)
                <div class="flex shrink-0 items-center gap-2 bg-orange-500 px-4 py-1.5 text-[11px] font-medium text-white">
                    <x-icon name="wifi-off" class="size-3.5" />Offline · đã lưu trên máy, sẽ tự đồng bộ
                </div>
            @endif
            <div class="relative flex min-h-0 flex-1 flex-col">{{ $slot }}</div>
        </div>
    </div>
    <figcaption class="mt-4 max-w-[300px] text-center">
        @if ($step)
            <span class="text-xs font-semibold text-brand-700">{{ $step }}</span>
        @endif
        <p class="text-sm font-medium text-slate-800">{{ $caption }}</p>
    </figcaption>
</figure>
