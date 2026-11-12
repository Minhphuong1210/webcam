@php
    use App\Support\DemoData;

    $cashStatuses = [
        'holding' => ['label' => 'KT đang giữ', 'color' => 'amber'],
        'overdue' => ['label' => 'Quá hạn bàn giao', 'color' => 'rose'],
        'handed' => ['label' => 'Đã bàn giao', 'color' => 'emerald'],
    ];
@endphp

<x-layouts.app title="Thu tiền & công nợ">
    <x-page-header title="Thu tiền & công nợ" subtitle="Tiền cọc · thanh toán · công nợ khách · đối soát tiền mặt Kỹ thuật thu hộ">
        <x-slot:actions>
            <button class="btn-primary" data-open="payment"><x-icon name="plus" class="size-4" />Ghi nhận thanh toán</button>
        </x-slot:actions>
    </x-page-header>

    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        <x-stat label="Đã thu tháng 11" value="165,0tr" hint="CK 128tr · TM 37tr" icon="wallet" tone="emerald" />
        <x-stat label="Tiền cọc đang giữ" value="20,0tr" hint="3 đơn chưa thi công xong" icon="cash" tone="brand" />
        <x-stat label="Công nợ phải thu" value="28,0tr" hint="1 đơn quá hạn" icon="alert" tone="amber" />
        <x-stat label="KT chưa bàn giao" value="18,8tr" hint="Quá hạn: 2,3tr" icon="users" tone="rose" />
    </div>

    <div class="mt-6 space-y-6">
        <div class="card overflow-hidden">
            <x-card-header title="Công nợ khách hàng" subtitle="Tổng giá trị đơn – tiền cọc – đã thanh toán – còn phải thu">
                <div class="flex gap-2">
                    <select class="input w-auto py-1.5 text-xs"><option>Tất cả trạng thái</option><option>Còn nợ</option><option>Quá hạn</option><option>Đã thu đủ</option></select>
                </div>
            </x-card-header>
            <div class="overflow-x-auto">
                <table class="table-base min-w-[900px]">
                    <thead>
                        <tr>
                            <th>Khách hàng / Đơn</th>
                            <th>Hình thức</th>
                            <th class="text-right">Tổng đơn</th>
                            <th class="text-right">Tiền cọc</th>
                            <th class="w-48">Đã thu</th>
                            <th class="text-right">Còn phải thu</th>
                            <th>Hạn thanh toán</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($receivables as $receivable)
                            @php($remaining = $receivable['total'] - $receivable['paid'])
                            @php($percent = (int) round($receivable['paid'] / $receivable['total'] * 100))
                            <tr>
                                <td>
                                    <p class="font-medium whitespace-nowrap text-slate-900">{{ $receivable['customer'] }}</p>
                                    <a href="{{ DemoData::order($receivable['order']) ? route('orders.show', $receivable['order']) : '#' }}" class="font-mono text-xs whitespace-nowrap text-brand-700 hover:underline">{{ $receivable['order'] }}</a>
                                </td>
                                <td class="text-xs whitespace-nowrap text-slate-600">{{ $receivable['method'] }}</td>
                                <td class="text-right whitespace-nowrap tabular-nums">{{ DemoData::money($receivable['total']) }}</td>
                                <td class="text-right whitespace-nowrap text-slate-600 tabular-nums">{{ $receivable['deposit'] ? DemoData::money($receivable['deposit']) : '—' }}</td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <div class="h-1.5 flex-1 rounded-full bg-slate-100"><div @class(['h-1.5 rounded-full', 'bg-emerald-500' => $percent === 100, 'bg-brand-500' => $percent < 100]) style="width: {{ $percent }}%"></div></div>
                                        <span class="w-9 text-right text-xs text-slate-500 tabular-nums">{{ $percent }}%</span>
                                    </div>
                                    <p class="mt-1 text-xs whitespace-nowrap text-slate-500 tabular-nums">{{ DemoData::money($receivable['paid']) }}</p>
                                </td>
                                <td @class(['text-right font-semibold whitespace-nowrap tabular-nums', 'text-emerald-700' => $remaining === 0, 'text-amber-700' => $remaining > 0])>{{ DemoData::money($remaining) }}</td>
                                <td>
                                    @if (str_contains($receivable['due'], 'Quá hạn'))
                                        <x-badge color="rose" dot>{{ $receivable['due'] }}</x-badge>
                                    @elseif ($remaining === 0)
                                        <x-badge color="emerald" dot>{{ $receivable['due'] }}</x-badge>
                                    @else
                                        <x-badge color="slate">{{ $receivable['due'] }}</x-badge>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card overflow-hidden">
            <x-card-header title="Đối soát tiền Kỹ thuật thu hộ" subtitle="Tiền mặt Kỹ thuật ghi nhận trên App → Kế toán xác nhận đã nhận bàn giao" />
            <div class="overflow-x-auto">
                <table class="table-base min-w-[760px]">
                    <thead><tr><th>Kỹ thuật</th><th>Đơn hàng</th><th>Thời điểm thu</th><th class="text-right">Số tiền</th><th>Tình trạng bàn giao</th><th class="text-right">Thao tác</th></tr></thead>
                    <tbody>
                        @foreach ($cashCollections as $collection)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-2.5 whitespace-nowrap">
                                        <x-avatar :initials="DemoData::initials($collection['tech'])" size="size-7" class="text-[10px]" />
                                        <span class="font-medium text-slate-900">{{ $collection['tech'] }}</span>
                                    </div>
                                </td>
                                <td class="font-mono text-xs whitespace-nowrap">{{ $collection['order'] }}</td>
                                <td class="text-xs whitespace-nowrap text-slate-500">{{ $collection['collected_at'] }}</td>
                                <td class="text-right font-semibold whitespace-nowrap tabular-nums">{{ DemoData::money($collection['amount']) }}</td>
                                <td><x-badge :color="$cashStatuses[$collection['status']]['color']" dot>{{ $cashStatuses[$collection['status']]['label'] }}</x-badge></td>
                                <td class="text-right">
                                    @if ($collection['status'] !== 'handed')
                                        <button class="btn-ghost px-2.5 py-1 text-xs whitespace-nowrap"><x-icon name="check" class="size-3.5" />Xác nhận đã nhận</button>
                                    @else
                                        <span class="text-xs text-slate-400">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="px-4 py-3 text-sm font-medium text-slate-700">Tổng Kỹ thuật đang giữ</td>
                            <td class="px-4 py-3 text-right font-semibold whitespace-nowrap text-amber-700 tabular-nums">{{ DemoData::money(collect($cashCollections)->where('status', '!=', 'handed')->sum('amount')) }}</td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <dialog id="payment" class="m-auto w-full max-w-md rounded-2xl p-0 shadow-2xl backdrop:bg-slate-900/40">
        <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
            <h2 class="font-semibold">Ghi nhận thanh toán</h2>
            <button data-close class="rounded-md p-1.5 hover:bg-slate-100"><x-icon name="x" class="size-4" /></button>
        </div>
        <div class="space-y-4 p-5">
            <div><label class="label">Đơn hàng</label><select class="input"><option>DH-2411-019 · Chị Lan – Căn hộ Sunrise</option><option>DH-2411-021 · Nhà hàng Biển Xanh</option></select></div>
            <div class="grid grid-cols-2 gap-3">
                <div><label class="label">Loại</label><select class="input"><option>Thanh toán</option><option>Tiền cọc</option></select></div>
                <div><label class="label">Hình thức</label><select class="input"><option>Chuyển khoản</option><option>Tiền mặt tại VP</option></select></div>
            </div>
            <div><label class="label">Số tiền</label><input class="input" value="4.200.000"></div>
            <div><label class="label">Ảnh chứng từ / UNC</label>
                <div class="grid place-items-center rounded-lg border-2 border-dashed border-slate-200 p-5 text-sm text-slate-500"><x-icon name="image" class="size-6" />Kéo thả hoặc bấm để tải lên</div>
            </div>
        </div>
        <div class="flex justify-end gap-2 border-t border-slate-100 px-5 py-3">
            <button data-close class="btn-ghost">Hủy</button>
            <button data-close class="btn-primary">Lưu</button>
        </div>
    </dialog>
</x-layouts.app>
