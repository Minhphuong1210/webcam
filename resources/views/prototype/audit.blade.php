@php
    $kinds = [
        'allocation' => ['label' => 'Tỷ lệ chia LN', 'color' => 'violet'],
        'cost' => ['label' => 'Chi phí', 'color' => 'teal'],
        'material' => ['label' => 'Vật tư', 'color' => 'amber'],
        'quote' => ['label' => 'Báo giá', 'color' => 'sky'],
        'discount' => ['label' => 'Giảm giá ngoại lệ', 'color' => 'rose'],
    ];
@endphp

<x-layouts.app title="Audit Log">
    <x-page-header title="Audit Log Inspector" subtitle="Lưu vết 100% thay đổi báo giá, vật tư, giảm giá, chi phí và tỷ lệ chia lợi nhuận">
        <x-slot:actions>
            <button class="btn-ghost"><x-icon name="download" class="size-4" />Xuất đối soát tháng</button>
        </x-slot:actions>
    </x-page-header>

    <div class="card overflow-hidden">
        <div class="flex flex-wrap gap-2 border-b border-slate-100 p-3">
            <div class="relative min-w-56 flex-1">
                <x-icon name="search" class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-slate-400" />
                <input class="input pl-9" placeholder="Mã đơn, mã nhân viên…">
            </div>
            <select class="input w-auto"><option>Mọi loại thay đổi</option>@foreach ($kinds as $kind)<option>{{ $kind['label'] }}</option>@endforeach</select>
            <input type="date" class="input w-auto" value="2026-11-11">
        </div>
        <div class="overflow-x-auto">
            <table class="table-base min-w-[980px]">
                <thead><tr><th>Thời gian</th><th>Người thực hiện</th><th>Loại</th><th>Hành động / Đối tượng</th><th>Trước → Sau</th><th class="text-right">Chênh lệch</th><th>Lý do</th></tr></thead>
                <tbody>
                    @foreach ($logs as $log)
                        @php([$logDate, $logTime] = explode(' ', $log['time']))
                        @php([$userCode, $userName] = explode(' · ', $log['user']))
                        <tr>
                            <td class="whitespace-nowrap"><p class="font-mono text-xs text-slate-900">{{ $logTime }}</p><p class="text-xs text-slate-400">{{ $logDate }}</p></td>
                            <td class="whitespace-nowrap"><p class="text-slate-900">{{ $userName }}</p><p class="font-mono text-xs text-slate-400">{{ $userCode }}</p></td>
                            <td><x-badge :color="$kinds[$log['kind']]['color']">{{ $kinds[$log['kind']]['label'] }}</x-badge></td>
                            <td class="min-w-48">
                                <p class="font-medium text-slate-900">{{ $log['action'] }}</p>
                                @if (\App\Support\DemoData::order($log['target']))
                                    <a href="{{ route('orders.show', $log['target']) }}" class="font-mono text-xs text-brand-700 hover:underline">{{ $log['target'] }}</a>
                                @else
                                    <span class="text-xs text-slate-500">{{ $log['target'] }}</span>
                                @endif
                            </td>
                            <td class="min-w-44"><p class="text-xs text-slate-400 line-through">{{ $log['before'] }}</p><p class="font-semibold text-slate-900">{{ $log['after'] }}</p></td>
                            <td @class(['text-right font-medium whitespace-nowrap tabular-nums', 'text-rose-600' => str_starts_with($log['diff'], '−'), 'text-emerald-700' => str_starts_with($log['diff'], '+')])>{{ $log['diff'] }}</td>
                            <td class="min-w-44 text-slate-500">{{ $log['reason'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
