@php
    $maximum = collect($weeks)->max('revenue');
    $staff = [
        ['Mai Anh', 'Sale', 9, 112.4, 46.1],
        ['Quang Huy', 'Sale', 6, 52.6, 21.1],
        ['Nguyễn Văn Hùng', 'Kỹ thuật', 7, 68.2, 27.9],
        ['Lê Quốc Bảo', 'Kỹ thuật', 6, 61.5, 24.6],
        ['Trần Minh Tuấn', 'Kỹ thuật', 4, 35.3, 14.7],
    ];
@endphp

<x-layouts.app title="Báo cáo thống kê">
    <x-page-header title="Báo cáo thống kê" subtitle="Doanh số, doanh thu, chi phí, lãi/lỗ theo thời gian, nhân viên và đơn hàng">
        <x-slot:actions>
            <select class="input w-auto"><option>6 tuần gần nhất</option><option>Quý 4/2026</option><option>Năm 2026</option></select>
            <button class="btn-ghost"><x-icon name="download" class="size-4" />Xuất báo cáo</button>
        </x-slot:actions>
    </x-page-header>

    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        <x-stat label="Doanh thu" value="535tr" hint="+12% so với kỳ trước" icon="chart" tone="brand" />
        <x-stat label="Chi phí" value="323tr" hint="Vật tư 271tr · khác 52tr" icon="box" />
        <x-stat label="Lợi nhuận" value="212tr" hint="Biên 39,6%" icon="wallet" tone="emerald" />
        <x-stat label="Đơn hoàn thành" value="38" hint="SLA đạt 92%" icon="check" tone="emerald" />
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-[1.4fr_1fr]">
        <div class="card p-5">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-semibold text-slate-900">Doanh thu & chi phí theo tuần <span class="font-normal text-slate-400">(triệu đồng)</span></h2>
                <div class="flex gap-4 text-xs text-slate-500">
                    <span class="flex items-center gap-1.5"><span class="size-2.5 rounded-sm bg-brand-600"></span>Doanh thu</span>
                    <span class="flex items-center gap-1.5"><span class="size-2.5 rounded-sm bg-slate-300"></span>Chi phí</span>
                </div>
            </div>
            <div class="mt-6 flex h-60 items-end gap-3 border-b border-slate-200 sm:gap-6">
                @foreach ($weeks as $week)
                    <div class="group flex h-full flex-1 flex-col justify-end">
                        <div class="flex h-full items-end justify-center gap-1">
                            <div class="relative w-full max-w-7 rounded-t bg-brand-600" style="height: {{ $week['revenue'] / $maximum * 100 }}%">
                                <span class="absolute -top-5 left-1/2 -translate-x-1/2 text-[11px] font-medium text-slate-700 tabular-nums">{{ $week['revenue'] }}</span>
                            </div>
                            <div class="w-full max-w-7 rounded-t bg-slate-300" style="height: {{ $week['cost'] / $maximum * 100 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-2 flex gap-3 sm:gap-6">
                @foreach ($weeks as $week)
                    <p class="flex-1 text-center text-[11px] text-slate-500">{{ $week['label'] }}</p>
                @endforeach
            </div>
        </div>

        <div class="card p-5">
            <h2 class="text-sm font-semibold text-slate-900">Đơn theo trạng thái kết thúc</h2>
            <div class="mt-5 space-y-4">
                @foreach ([['Hoàn thành đúng SLA', 35, 'bg-emerald-500'], ['Hoàn thành trễ SLA', 3, 'bg-amber-500'], ['Khách hủy sau khảo sát', 4, 'bg-rose-400'], ['Đang bảo hành', 2, 'bg-fuchsia-400']] as [$label, $count, $color])
                    <div>
                        <div class="flex justify-between text-sm"><span class="text-slate-600">{{ $label }}</span><span class="font-medium tabular-nums">{{ $count }}</span></div>
                        <div class="mt-1.5 h-2 rounded-full bg-slate-100"><div class="h-2 rounded-full {{ $color }}" style="width: {{ $count / 44 * 100 }}%"></div></div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card mt-6 overflow-hidden">
        <x-card-header title="Hiệu quả theo nhân viên" subtitle="Doanh thu & lợi nhuận gộp của đơn tham gia (triệu đồng)" />
        <div class="overflow-x-auto">
            <table class="table-base min-w-[640px]">
                <thead><tr><th>Nhân viên</th><th>Bộ phận</th><th class="text-right">Số đơn</th><th class="text-right">Doanh thu</th><th class="text-right">Lợi nhuận gộp</th><th class="text-right">Biên LN</th></tr></thead>
                <tbody>
                    @foreach ($staff as [$name, $department, $orderCount, $revenue, $profit])
                        <tr>
                            <td><div class="flex items-center gap-2"><x-avatar :initials="\App\Support\DemoData::initials($name)" size="size-7" class="text-[10px]" /><span class="font-medium text-slate-900">{{ $name }}</span></div></td>
                            <td>{{ $department }}</td>
                            <td class="text-right tabular-nums">{{ $orderCount }}</td>
                            <td class="text-right tabular-nums">{{ number_format($revenue, 1, ',', '.') }}</td>
                            <td class="text-right font-medium text-emerald-700 tabular-nums">{{ number_format($profit, 1, ',', '.') }}</td>
                            <td class="text-right tabular-nums">{{ round($profit / $revenue * 100) }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
