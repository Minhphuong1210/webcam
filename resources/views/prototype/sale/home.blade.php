<x-layouts.app title="Tổng quan Sale">
    <x-page-header title="Chào Mai Anh 👋" subtitle="Tháng 11/2026 · bạn đang phụ trách {{ count($orders) }} đơn">
        <x-slot:actions>
            <a href="{{ route('leads.create') }}" class="btn-primary"><x-icon name="plus" class="size-4" />Tạo lead mới</a>
        </x-slot:actions>
    </x-page-header>

    <div class="grid gap-4 md:grid-cols-3">
        <x-stat label="Lead tạo trong tháng" value="14" hint="Chuyển đổi thành đơn: 9 (64%)" icon="user-plus" tone="brand" />
        <x-stat label="Đơn hoàn thành" value="5" hint="Đang xử lý: 4" icon="check" tone="emerald" />
        <x-stat label="Thời gian đẩy lead TB" value="3′40″" hint="SLA dưới 5 phút ✓" icon="clock" />
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-[1fr_380px]">
        <div class="card overflow-hidden">
            <x-card-header title="Tiến độ đơn tôi phụ trách" subtitle="Cập nhật real-time từ Kế toán & Kỹ thuật">
                <a href="{{ route('orders.index') }}" class="text-sm font-medium text-brand-700">Xem tất cả</a>
            </x-card-header>
            <ul class="divide-y divide-slate-100">
                @foreach ($orders as $order)
                    @php($step = $statuses[$order['status']]['step'])
                    <li>
                        <a href="{{ route('orders.show', $order['code']) }}" class="flex flex-col gap-3 px-4 py-3.5 hover:bg-slate-50 sm:flex-row sm:items-center">
                            <div class="min-w-0 flex-1">
                                <p class="font-medium text-slate-900">{{ $order['customer'] }} <span class="ml-1 font-mono text-xs font-normal text-slate-400">{{ $order['code'] }}</span></p>
                                <p class="truncate text-sm text-slate-500">{{ $order['need'] }}</p>
                            </div>
                            <div class="flex items-center gap-4 sm:w-72">
                                <div class="flex flex-1 gap-1">
                                    @for ($index = 1; $index <= 6; $index++)
                                        <span @class(['h-1.5 flex-1 rounded-full', 'bg-brand-500' => $index <= $step, 'bg-slate-200' => $index > $step])></span>
                                    @endfor
                                </div>
                                <x-status :status="$order['status']" />
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="space-y-4">
            <div class="card p-4">
                <h3 class="text-sm font-semibold text-slate-900">Ví hoa hồng tháng 11 · lợi nhuận được chia</h3>
                <dl class="mt-4 space-y-3 text-sm">
                    <div class="flex items-center justify-between">
                        <dt class="text-slate-500">Doanh thu đơn hoàn thành</dt>
                        <dd class="font-medium tabular-nums">51.300.000đ</dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-slate-500">Lợi nhuận <span class="text-xs">(doanh thu − tổng chi phí)</span></dt>
                        <dd class="font-semibold text-brand-700 tabular-nums">19.100.000đ</dd>
                    </div>
                    <div class="flex items-center justify-between rounded-lg bg-emerald-50 px-3 py-2.5">
                        <dt class="font-medium text-emerald-900">Phần Sale được chia (10%)</dt>
                        <dd class="text-lg font-semibold text-emerald-700 tabular-nums">1.910.000đ</dd>
                    </div>
                </dl>
                <p class="mt-3 text-xs text-slate-500">Chỉ tính đơn đã HOÀN THÀNH & ĐÃ THU TIỀN. Tỷ lệ chia do Quản lý thiết lập.</p>
            </div>

            <div class="card p-4">
                <h3 class="text-sm font-semibold text-slate-900">Cần bạn chú ý</h3>
                <ul class="mt-3 space-y-3 text-sm">
                    <li class="flex gap-2.5"><x-icon name="clock" class="mt-0.5 size-4 shrink-0 text-amber-600" /><span><b>Chị Hạnh</b> bận – Kế toán hẹn gọi lại 14:00. Bạn có thể nhắn khách trước.</span></li>
                    <li class="flex gap-2.5"><x-icon name="flag" class="mt-0.5 size-4 shrink-0 text-amber-600" /><span><b>Minh Phát</b> được gắn ưu tiên, KT đang trễ 8 phút.</span></li>
                </ul>
            </div>
        </div>
    </div>
</x-layouts.app>
