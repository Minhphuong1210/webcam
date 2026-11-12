<x-layouts.app title="Control Tower">
    <x-page-header title="Control Tower" subtitle="Giám sát 360° real-time · Thứ Tư, 11/11/2026 · cập nhật 5 giây trước">
        <x-slot:actions>
            <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700 ring-1 ring-emerald-200">
                <span class="relative flex size-2"><span class="absolute inline-flex size-full animate-ping rounded-full bg-emerald-400 opacity-75"></span><span class="relative inline-flex size-2 rounded-full bg-emerald-500"></span></span>
                Live
            </span>
            <select class="input w-auto py-1.5"><option>Hôm nay</option><option>7 ngày</option><option>Tháng này</option></select>
        </x-slot:actions>
    </x-page-header>

    <div class="grid grid-cols-2 gap-4 lg:grid-cols-5">
        <x-stat label="Đơn đang xử lý" value="9" hint="+3 lead mới hôm nay" icon="list" tone="brand" />
        <x-stat label="Vi phạm SLA" value="2" hint="1 quá 30′ · 1 chờ Admin" icon="alert" tone="rose" />
        <x-stat label="Doanh thu tháng 11" value="165,0tr" hint="Lợi nhuận gộp 67,2tr" icon="chart" tone="emerald" />
        <x-stat label="Công nợ phải thu" value="28,0tr" hint="1 đơn quá hạn 3 ngày" icon="wallet" tone="amber" />
        <x-stat label="Tiền KT đang giữ" value="18,8tr" hint="3 KT · 1 quá hạn bàn giao" icon="cash" />
    </div>

    {{-- Red alerts --}}
    <section class="mt-6 overflow-hidden rounded-xl border border-rose-200 bg-white">
        <div class="flex items-center gap-2 border-b border-rose-100 bg-rose-50 px-4 py-3">
            <x-icon name="alert" class="size-5 text-rose-600" />
            <h2 class="text-sm font-semibold text-rose-900">Báo động khẩn · cần Admin xử lý</h2>
            <span class="ml-auto text-xs text-rose-700">SLA duyệt ngoại lệ &lt; 60 phút</span>
        </div>
        <ul class="divide-y divide-slate-100">
            @foreach ($alerts as $alert)
                <li class="flex flex-col gap-3 px-4 py-3.5 md:flex-row md:items-center">
                    <div class="flex flex-1 gap-3">
                        <span @class([
                            'mt-0.5 grid size-9 shrink-0 place-items-center rounded-lg',
                            'bg-rose-100 text-rose-700' => $alert['type'] === 'discount',
                            'bg-amber-100 text-amber-700' => $alert['type'] === 'material',
                            'bg-slate-100 text-slate-700' => $alert['type'] === 'gps',
                        ])>
                            <x-icon :name="['discount' => 'wallet', 'material' => 'box', 'gps' => 'pin'][$alert['type']]" class="size-4" />
                        </span>
                        <div>
                            <p class="text-sm font-medium text-slate-900">{{ $alert['title'] }}
                                <a href="{{ route('orders.show', $alert['order']) }}" class="ml-1 font-mono text-xs text-brand-700 hover:underline">{{ $alert['order'] }}</a>
                            </p>
                            <p class="mt-0.5 text-sm text-slate-500">{{ $alert['detail'] }}</p>
                            <p class="mt-1 text-xs text-slate-400">{{ $alert['from'] }} · {{ $alert['time'] }}</p>
                        </div>
                    </div>
                    <div class="flex shrink-0 gap-2 md:pl-4">
                        @if ($alert['type'] === 'gps')
                            <button class="btn-ghost py-1.5"><x-icon name="call" class="size-4" />Gọi KT</button>
                            <button class="btn-ghost py-1.5">Bỏ qua</button>
                        @else
                            <a href="{{ route('orders.show', $alert['order']) }}" class="btn-ghost py-1.5"><x-icon name="image" class="size-4" />Xem media</a>
                            <button class="btn-ghost py-1.5">Từ chối</button>
                            <button class="btn-primary py-1.5"><x-icon name="check" class="size-4" />Duyệt 1-click</button>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    </section>

    {{-- Kanban pipeline --}}
    <section class="mt-6">
        <div class="mb-3 flex items-center justify-between">
            <h2 class="text-base font-semibold text-slate-900">Visual Pipeline · 6 bước</h2>
            <div class="flex items-center gap-3 text-xs text-slate-500">
                <span class="flex items-center gap-1"><span class="size-2 rounded-full bg-rose-500"></span>Vi phạm SLA</span>
                <span class="flex items-center gap-1"><span class="size-2 rounded-full bg-orange-500"></span>Ngoại lệ</span>
                <span class="flex items-center gap-1"><x-icon name="flag" class="size-3 text-amber-600" />Ưu tiên</span>
            </div>
        </div>

        @php
            $columns = [
                1 => 'Chờ xác nhận',
                2 => 'Khảo sát',
                3 => 'Báo giá',
                4 => 'Thi công',
                5 => 'Nghiệm thu & thu tiền',
                6 => 'Hoàn thành / Bảo hành',
            ];
            $byStep = collect($orders)->groupBy(fn ($order) => $statuses[$order['status']]['step']);
        @endphp

        <div class="-mx-4 overflow-x-auto px-4 pb-2 sm:mx-0 sm:px-0">
            <div class="grid min-w-[1100px] grid-cols-6 gap-3">
                @foreach ($columns as $step => $label)
                    <div class="rounded-xl bg-slate-100/80 p-2">
                        <div class="flex items-center justify-between px-1.5 pt-1 pb-2.5">
                            <p class="text-xs font-semibold text-slate-600"><span class="text-slate-400">{{ $step }}.</span> {{ $label }}</p>
                            <span class="rounded-full bg-white px-1.5 text-xs font-medium text-slate-500">{{ $byStep->get($step, collect())->count() }}</span>
                        </div>
                        <div class="space-y-2">
                            @foreach ($byStep->get($step, collect()) as $order)
                                @php
                                    $isException = in_array($order['status'], ['khach_ban', 'khach_hoan', 'che_dat', 'bao_hanh']);
                                @endphp
                                <a href="{{ route('orders.show', $order['code']) }}" @class([
                                    'block rounded-lg border bg-white p-3 shadow-xs transition hover:shadow-md',
                                    'border-rose-300 ring-1 ring-rose-200' => $order['sla']['state'] === 'late',
                                    'border-orange-200' => $isException && $order['sla']['state'] !== 'late',
                                    'border-slate-200' => ! $isException && $order['sla']['state'] !== 'late',
                                ])>
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="font-mono text-[11px] text-slate-400">{{ $order['code'] }}</span>
                                        @if ($order['priority'])
                                            <x-icon name="flag" class="size-3.5 text-amber-600" />
                                        @endif
                                    </div>
                                    <p class="mt-1 text-sm leading-snug font-medium text-slate-900">{{ $order['customer'] }}</p>
                                    <p class="mt-0.5 line-clamp-1 text-xs text-slate-500">{{ $order['need'] }}</p>
                                    @if ($isException)
                                        <x-status :status="$order['status']" class="mt-2 max-w-full whitespace-normal!" />
                                    @endif
                                    <div class="mt-2.5 flex items-center justify-between gap-2 border-t border-slate-100 pt-2">
                                        <x-sla :sla="$order['sla']" class="[&>svg]:shrink-0" />
                                        @if ($order['tech'])
                                            <x-avatar :initials="\App\Support\DemoData::initials($order['tech'])" size="size-6" class="text-[10px]" />
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- GPS live map --}}
    <section class="mt-6 grid gap-4 lg:grid-cols-[1fr_340px]">
        <div class="card overflow-hidden">
            <x-card-header title="GPS Live Map Tracker" subtitle="Vị trí Kỹ thuật viên · heartbeat 30 giây">
                <div class="flex gap-1.5">
                    @foreach ($technicianStatuses as $definition)
                        <x-badge :color="$definition['color']" dot class="hidden sm:inline-flex">{{ $definition['label'] }}</x-badge>
                    @endforeach
                </div>
            </x-card-header>
            <div class="relative h-[360px] bg-[#e8eef1]">
                <svg class="absolute inset-0 size-full" preserveAspectRatio="none" viewBox="0 0 100 100" aria-hidden="true">
                    <path d="M0 48 C 20 44, 35 58, 52 50 S 80 36, 100 42" stroke="#9cc7d6" stroke-width="5" fill="none" opacity=".7" />
                    <path d="M0 20 L100 28 M0 75 L100 68 M22 0 L30 100 M60 0 L55 100 M84 0 L88 100" stroke="#fff" stroke-width="1.4" fill="none" />
                    <path d="M0 35 L100 85 M10 100 L70 0" stroke="#fff" stroke-width=".7" fill="none" />
                </svg>
                @php
                    $pinColors = ['free' => 'bg-emerald-500', 'moving' => 'bg-amber-500', 'surveying' => 'bg-sky-500', 'installing' => 'bg-blue-600', 'offline' => 'bg-slate-400'];
                @endphp
                @foreach ($technicians as $technician)
                    <div class="group absolute -translate-x-1/2 -translate-y-full" style="left: {{ $technician['lng'] }}%; top: {{ $technician['lat'] }}%">
                        <div class="mb-1 hidden rounded-md bg-ink-900 px-2 py-1 text-[11px] whitespace-nowrap text-white group-hover:block">{{ $technician['name'] }} · {{ $technicianStatuses[$technician['status']]['label'] }}</div>
                        <div class="mx-auto flex flex-col items-center">
                            <span class="grid size-8 place-items-center rounded-full border-2 border-white text-[10px] font-semibold text-white shadow-md {{ $pinColors[$technician['status']] }}">{{ $technician['initials'] }}</span>
                            <span class="-mt-0.5 size-2 rotate-45 {{ $pinColors[$technician['status']] }}"></span>
                        </div>
                    </div>
                @endforeach
                <div class="absolute top-[47%] left-[42%]">
                    <span class="flex size-4 items-center justify-center rounded-full bg-rose-500/20 ring-8 ring-rose-500/10"><span class="size-2 rounded-full bg-rose-600"></span></span>
                </div>
                <div class="absolute right-3 bottom-3 rounded-lg bg-white/95 px-3 py-2 text-xs shadow-sm">
                    <p class="font-medium text-slate-900">DH-2411-026 · cách KT01 380m</p>
                    <p class="text-rose-600">Check-in ngoài geofence 50m</p>
                </div>
            </div>
        </div>

        <div class="card">
            <x-card-header title="Đội Kỹ thuật" subtitle="5 người · 1 rảnh" />
            <ul class="divide-y divide-slate-100">
                @foreach ($technicians as $technician)
                    <li class="flex items-center gap-3 px-4 py-3">
                        <x-avatar :initials="$technician['initials']" />
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-medium text-slate-900">{{ $technician['name'] }}</p>
                            <p class="text-xs text-slate-500">{{ $technician['area'] }} · {{ $technician['jobs_today'] }} việc hôm nay</p>
                        </div>
                        <x-badge :color="$technicianStatuses[$technician['status']]['color']" dot>{{ $technicianStatuses[$technician['status']]['label'] }}</x-badge>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
</x-layouts.app>
