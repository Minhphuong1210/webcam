@php
    use App\Support\DemoData;

    $rows = collect($profitOrders)->map(function (array $order): array {
        $order['total_cost'] = $order['material_cost'] + $order['extra_cost'] + $order['other_cost'];
        $order['profit'] = $order['revenue'] - $order['total_cost'];

        return $order;
    });
    $totalRevenue = $rows->sum('revenue');
    $totalCost = $rows->sum('total_cost');
    $totalProfit = $rows->sum('profit');
    $margin = $totalRevenue > 0 ? round($totalProfit / $totalRevenue * 100, 1) : 0;

    $people = collect();
    foreach ($rows as $row) {
        foreach (['tech' => $row['tech'], 'sale' => $row['sale'], 'accountant' => $row['accountant']] as $roleKey => $name) {
            $current = $people->get($name, ['name' => $name, 'role' => $roleKey, 'profit' => 0, 'orders' => 0]);
            $current['profit'] += $row['profit'];
            $current['orders']++;
            $people->put($name, $current);
        }
    }
@endphp

<x-layouts.app title="Chi phí & lợi nhuận">
    <x-page-header title="Chi phí & lợi nhuận" subtitle="Lợi nhuận = Doanh thu − Tổng chi phí thực tế (vật tư + phát sinh + chi phí khác). Lợi nhuận từng đơn được chia theo tỷ lệ cấu hình.">
        <x-slot:actions>
            <select class="input w-auto"><option>Tháng 11/2026</option><option>Tháng 10/2026</option></select>
            <button class="btn-ghost"><x-icon name="download" class="size-4" />Xuất Excel</button>
            <button class="btn-primary"><x-icon name="check" class="size-4" />Chốt chia lợi nhuận tháng</button>
        </x-slot:actions>
    </x-page-header>

    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        <x-stat label="Doanh thu (đơn đã thu đủ)" :value="DemoData::money($totalRevenue)" :hint="$rows->count().' đơn hoàn thành'" icon="chart" tone="brand" />
        <x-stat label="Tổng chi phí" :value="DemoData::money($totalCost)" hint="Vật tư, phát sinh, chi phí khác" icon="box" tone="amber" />
        <x-stat label="Lợi nhuận" :value="DemoData::money($totalProfit)" :hint="'Biên lợi nhuận '.str_replace('.', ',', (string) $margin).'%'" icon="wallet" tone="emerald" />
        <x-stat label="Công ty giữ lại" :value="DemoData::money((int) round($totalProfit * $profitSplit['company']['percent'] / 100))" :hint="$profitSplit['company']['percent'].'% lợi nhuận'" icon="shield" />
    </div>

    <form class="card mt-6 p-5" data-split-form onsubmit="return false">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <h2 class="text-sm font-semibold text-slate-900">Tỷ lệ chia lợi nhuận</h2>
                <p class="mt-1 text-sm text-slate-500">Quản lý thiết lập tỷ lệ cho Kỹ thuật, Sale, Kế toán và Công ty. Tổng phải bằng 100% · thay đổi được ghi vào Audit Log.</p>
            </div>
            <div class="flex shrink-0 items-center gap-3">
                <span class="text-sm text-slate-600">Tổng: <b data-split-total class="tabular-nums">100%</b></span>
                <button type="reset" class="btn-ghost">Khôi phục mặc định</button>
                <button class="btn-primary" data-split-save><x-icon name="check" class="size-4" />Lưu tỷ lệ</button>
            </div>
        </div>
        <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($profitSplit as $key => $split)
                <div class="rounded-lg border border-slate-200 p-3">
                    <div class="flex items-center justify-between gap-3">
                        <label for="split-{{ $key }}" class="text-sm font-medium text-slate-700">{{ $split['label'] }}</label>
                        <div class="flex items-center gap-1.5">
                            <input id="split-{{ $key }}" type="number" min="0" max="100" value="{{ $split['percent'] }}" data-split="{{ $key }}" class="input w-20 py-1.5 text-right tabular-nums">
                            <span class="text-sm text-slate-400">%</span>
                        </div>
                    </div>
                    <div class="mt-3 h-1.5 rounded-full bg-slate-100"><div class="h-1.5 rounded-full bg-brand-500 transition-all" data-split-bar="{{ $key }}" style="width: {{ $split['percent'] }}%"></div></div>
                </div>
            @endforeach
        </div>
        <p class="mt-3 hidden text-sm text-rose-600" data-split-error>Tổng tỷ lệ phải bằng 100% mới lưu được.</p>
    </form>

    <div class="mt-6">
        <div class="card overflow-hidden">
            <x-card-header title="Lợi nhuận từng đơn" subtitle="Chỉ tính đơn đã hoàn thành & đã thu đủ tiền">
                <x-badge color="emerald" dot>Đã đối soát</x-badge>
            </x-card-header>
            <div class="overflow-x-auto">
                <table class="table-base min-w-[1100px]" data-profit-table>
                    <thead>
                        <tr>
                            <th>Đơn hàng</th>
                            <th class="text-right">Doanh thu</th>
                            <th class="text-right">Vật tư</th>
                            <th class="text-right">Phát sinh</th>
                            <th class="text-right">Chi phí khác</th>
                            <th class="text-right">Lợi nhuận</th>
                            @foreach ($profitSplit as $key => $split)
                                <th class="text-right">{{ $split['label'] }} <span class="text-brand-600" data-split-label="{{ $key }}">{{ $split['percent'] }}%</span></th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rows as $row)
                            <tr data-profit-row data-profit="{{ $row['profit'] }}">
                                <td>
                                    <p class="font-medium whitespace-nowrap text-slate-900">{{ $row['customer'] }}</p>
                                    <p class="text-xs whitespace-nowrap text-slate-500"><span class="font-mono">{{ $row['order'] }}</span> · {{ $row['note'] }}</p>
                                </td>
                                <td class="text-right whitespace-nowrap tabular-nums">{{ DemoData::money($row['revenue']) }}</td>
                                <td class="text-right whitespace-nowrap text-slate-600 tabular-nums">{{ DemoData::money($row['material_cost']) }}</td>
                                <td class="text-right whitespace-nowrap text-slate-600 tabular-nums">{{ $row['extra_cost'] ? DemoData::money($row['extra_cost']) : '—' }}</td>
                                <td class="text-right whitespace-nowrap text-slate-600 tabular-nums">{{ DemoData::money($row['other_cost']) }}</td>
                                <td class="text-right font-semibold whitespace-nowrap text-emerald-700 tabular-nums">{{ DemoData::money($row['profit']) }}</td>
                                @foreach ($profitSplit as $key => $split)
                                    <td class="text-right whitespace-nowrap tabular-nums">
                                        <p data-share="{{ $key }}">{{ DemoData::money((int) round($row['profit'] * $split['percent'] / 100)) }}</p>
                                        <p class="text-xs text-slate-400">{{ ['tech' => $row['tech'], 'sale' => $row['sale'], 'accountant' => $row['accountant'], 'company' => 'CamPro'][$key] }}</p>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-slate-50">
                        <tr data-profit-row data-profit="{{ $totalProfit }}">
                            <td class="px-4 py-3 text-sm font-semibold text-slate-900">Tổng cộng</td>
                            <td class="px-4 py-3 text-right font-semibold whitespace-nowrap tabular-nums">{{ DemoData::money($totalRevenue) }}</td>
                            <td colspan="3" class="px-4 py-3 text-right font-semibold whitespace-nowrap text-slate-600 tabular-nums">−{{ DemoData::money($totalCost) }}</td>
                            <td class="px-4 py-3 text-right font-semibold whitespace-nowrap text-emerald-700 tabular-nums">{{ DemoData::money($totalProfit) }}</td>
                            @foreach ($profitSplit as $key => $split)
                                <td class="px-4 py-3 text-right font-semibold whitespace-nowrap tabular-nums" data-share="{{ $key }}">{{ DemoData::money((int) round($totalProfit * $split['percent'] / 100)) }}</td>
                            @endforeach
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>

    <div class="card mt-6 overflow-hidden">
        <x-card-header title="Tổng hợp phần lợi nhuận theo nhân viên" subtitle="Theo tỷ lệ đang áp dụng · tháng 11/2026" />
        <div class="overflow-x-auto">
            <table class="table-base min-w-[640px]">
                <thead><tr><th>Nhân viên</th><th>Vai trò</th><th class="text-right">Số đơn tham gia</th><th class="text-right">Lợi nhuận các đơn</th><th class="text-right">Phần được chia</th></tr></thead>
                <tbody>
                    @foreach ($people->sortByDesc(fn ($person) => $person['profit'] * $profitSplit[$person['role']]['percent']) as $person)
                        <tr data-profit-row data-profit="{{ $person['profit'] }}">
                            <td><div class="flex items-center gap-2.5 whitespace-nowrap"><x-avatar :initials="DemoData::initials($person['name'])" size="size-7" class="text-[10px]" /><span class="font-medium text-slate-900">{{ $person['name'] }}</span></div></td>
                            <td class="text-slate-600">{{ $profitSplit[$person['role']]['label'] }}</td>
                            <td class="text-right tabular-nums">{{ $person['orders'] }}</td>
                            <td class="text-right whitespace-nowrap tabular-nums">{{ DemoData::money($person['profit']) }}</td>
                            <td class="text-right font-semibold whitespace-nowrap text-brand-700 tabular-nums" data-share="{{ $person['role'] }}">{{ DemoData::money((int) round($person['profit'] * $profitSplit[$person['role']]['percent'] / 100)) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
