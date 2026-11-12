<x-layouts.app title="Đơn hàng">
    <x-page-header title="Đơn hàng" subtitle="Toàn bộ đơn theo trạng thái nghiệp vụ, SLA và người phụ trách">
        <x-slot:actions>
            <button class="btn-ghost"><x-icon name="download" class="size-4" />Xuất Excel</button>
            <a href="{{ route('leads.create') }}" class="btn-primary"><x-icon name="plus" class="size-4" />Tạo lead</a>
        </x-slot:actions>
    </x-page-header>

    <div class="-mx-4 mb-4 flex gap-2 overflow-x-auto px-4 pb-1 sm:mx-0 sm:px-0">
        <a href="{{ route('orders.index') }}" @class([
            'shrink-0 rounded-full px-3 py-1.5 text-sm font-medium transition',
            'bg-ink-900 text-white' => ! $activeStatus,
            'bg-white text-slate-600 ring-1 ring-slate-200 hover:bg-slate-50' => $activeStatus,
        ])>Tất cả <span class="opacity-60">{{ array_sum($counts) }}</span></a>
        @foreach ($statuses as $key => $definition)
            @continue(! isset($counts[$key]))
            <a href="{{ route('orders.index', ['status' => $key]) }}" @class([
                'shrink-0 rounded-full px-3 py-1.5 text-sm font-medium transition',
                'bg-ink-900 text-white' => $activeStatus === $key,
                'bg-white text-slate-600 ring-1 ring-slate-200 hover:bg-slate-50' => $activeStatus !== $key,
            ])>{{ $definition['label'] }} <span class="opacity-60">{{ $counts[$key] }}</span></a>
        @endforeach
    </div>

    <div class="card overflow-hidden">
        <div class="flex flex-wrap items-center gap-2 border-b border-slate-100 p-3">
            <div class="relative min-w-56 flex-1">
                <x-icon name="search" class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-slate-400" />
                <input class="input pl-9" placeholder="Mã đơn, khách hàng, SĐT…">
            </div>
            <select class="input w-auto"><option>Mọi Sale</option><option>Mai Anh</option><option>Quang Huy</option></select>
            <select class="input w-auto"><option>Mọi Kỹ thuật</option><option>Nguyễn Văn Hùng</option><option>Lê Quốc Bảo</option></select>
            <select class="input w-auto"><option>Tháng 11/2026</option><option>Tháng 10/2026</option></select>
        </div>
        <div class="overflow-x-auto">
            <table class="table-base min-w-[1040px]">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>Nhu cầu</th>
                        <th>Trạng thái</th>
                        <th>SLA</th>
                        <th>Sale / KT</th>
                        <th class="text-right">Giá trị</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>
                                <a href="{{ route('orders.show', $order['code']) }}" class="font-mono text-xs font-medium whitespace-nowrap text-brand-700 hover:underline">{{ $order['code'] }}</a>
                                <p class="text-xs text-slate-400">{{ $order['created'] }}</p>
                            </td>
                            <td class="min-w-44">
                                <p class="flex items-center gap-1.5 font-medium text-slate-900">
                                    {{ $order['customer'] }}
                                    @if ($order['priority'])
                                        <x-icon name="flag" class="size-3.5 text-amber-600" />
                                    @endif
                                </p>
                                <p class="text-xs text-slate-500">{{ $order['phone'] }}</p>
                            </td>
                            <td class="max-w-52"><p class="truncate" title="{{ $order['need'] }}">{{ $order['need'] }}</p></td>
                            <td><x-status :status="$order['status']" /></td>
                            <td class="whitespace-nowrap"><x-sla :sla="$order['sla']" /></td>
                            <td class="text-xs whitespace-nowrap">
                                <p class="font-medium text-slate-700">{{ $order['sale'] }}</p>
                                <p class="text-slate-500">{{ $order['tech'] ?? 'Chưa gán KT' }}</p>
                            </td>
                            <td class="text-right font-medium whitespace-nowrap tabular-nums">{{ \App\Support\DemoData::money($order['value']) }}</td>
                            <td class="text-right">
                                <a href="{{ route('orders.show', $order['code']) }}" class="inline-flex rounded-md p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-700"><x-icon name="chevron-right" class="size-4" /></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex items-center justify-between px-4 py-3 text-sm text-slate-500">
            <span>Hiển thị {{ count($orders) }} đơn</span>
            <div class="flex gap-1">
                <button class="btn-ghost px-2.5 py-1"><x-icon name="chevron-left" class="size-4" /></button>
                <button class="btn-ghost px-2.5 py-1"><x-icon name="chevron-right" class="size-4" /></button>
            </div>
        </div>
    </div>
</x-layouts.app>
