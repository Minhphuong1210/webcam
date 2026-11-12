@php
    use App\Support\DemoData;

    $queue = collect($orders)->whereIn('status', ['cho_xac_nhan', 'khach_ban', 'cho_khao_sat', 'cho_bao_gia', 'che_dat', 'bao_hanh'])
        ->sortByDesc(fn ($order) => [$order['priority'], $order['sla']['state'] === 'late'])
        ->values();
    $selected = collect($orders)->firstWhere('code', 'DH-2411-028');
    $distances = ['KT01' => '2,1 km', 'KT02' => '5,4 km', 'KT03' => '9,8 km', 'KT04' => '1,3 km', 'KT05' => '14 km'];
@endphp

<x-layouts.app title="Bàn điều phối">
    <x-page-header title="Bàn điều phối" subtitle="Xác minh khách · gán Kỹ thuật · hẹn lịch · nhắc 2 tầng">
        <x-slot:actions>
            <a href="{{ route('schedule') }}" class="btn-ghost"><x-icon name="calendar" class="size-4" />Lịch triển khai</a>
        </x-slot:actions>
    </x-page-header>

    <div class="grid gap-6 xl:grid-cols-[380px_1fr]">
        {{-- Queue --}}
        <div class="card overflow-hidden">
            <x-card-header title="Hàng đợi xử lý" subtitle="Ưu tiên & vi phạm SLA lên đầu">
                <x-badge color="rose">{{ $queue->count() }}</x-badge>
            </x-card-header>
            <ul class="divide-y divide-slate-100 overflow-y-auto">
                @foreach ($queue as $order)
                    <li @class(['relative px-4 py-3', 'bg-brand-50/70' => $order['code'] === $selected['code']])>
                        @if ($order['code'] === $selected['code'])
                            <span class="absolute inset-y-0 left-0 w-1 bg-brand-600"></span>
                        @endif
                        <div class="flex items-center justify-between gap-2">
                            <span class="font-mono text-xs text-slate-400">{{ $order['code'] }}</span>
                            <x-sla :sla="$order['sla']" />
                        </div>
                        <p class="mt-1 flex items-center gap-1.5 text-sm font-medium text-slate-900">
                            {{ $order['customer'] }}
                            @if ($order['priority'])
                                <x-badge color="amber" class="py-0 text-[10px]">ƯU TIÊN</x-badge>
                            @endif
                        </p>
                        <div class="mt-1.5"><x-status :status="$order['status']" /></div>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Selected order --}}
        <div class="space-y-6">
            <div class="card p-5">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <p class="font-mono text-xs text-slate-400">{{ $selected['code'] }} · Sale {{ $selected['sale'] }} · tạo {{ $selected['created'] }}</p>
                        <h2 class="mt-1 text-lg font-semibold text-slate-900">{{ $selected['customer'] }}</h2>
                        <p class="mt-1 text-sm text-slate-600">{{ $selected['need'] }}</p>
                        <p class="mt-2 flex items-center gap-1.5 text-sm text-slate-500"><x-icon name="pin" class="size-4" />{{ $selected['address'] }}</p>
                    </div>
                    <a href="tel:0908123456" class="btn-primary"><x-icon name="call" class="size-4" />Gọi {{ $selected['phone'] }}</a>
                </div>

                <p class="mt-6 text-sm font-medium text-slate-900">Kết quả gọi xác minh</p>
                <div class="mt-2 grid gap-2 sm:grid-cols-3" data-tabs>
                    <button data-tab="ok" aria-selected="true" class="rounded-lg border border-slate-200 p-3 text-left text-sm aria-selected:border-emerald-500 aria-selected:bg-emerald-50">
                        <x-icon name="check" class="size-4 text-emerald-600" /><p class="mt-1 font-medium">Xác minh OK</p><p class="text-xs text-slate-500">Gán Kỹ thuật & bắn lên App</p>
                    </button>
                    <button data-tab="busy" aria-selected="false" class="rounded-lg border border-slate-200 p-3 text-left text-sm aria-selected:border-orange-500 aria-selected:bg-orange-50">
                        <x-icon name="clock" class="size-4 text-orange-600" /><p class="mt-1 font-medium">Khách bận / Chờ gọi lại</p><p class="text-xs text-slate-500">Hẹn lại + báo Sale</p>
                    </button>
                    <button data-tab="cancel" aria-selected="false" class="rounded-lg border border-slate-200 p-3 text-left text-sm aria-selected:border-rose-500 aria-selected:bg-rose-50">
                        <x-icon name="x" class="size-4 text-rose-600" /><p class="mt-1 font-medium">Không liên lạc được / Hủy</p><p class="text-xs text-slate-500">Ghi lý do</p>
                    </button>

                    <div data-panel="ok" class="sm:col-span-3">
                        <div class="mt-4 grid gap-4 sm:grid-cols-2">
                            <div><label class="label">Loại công việc</label><select class="input"><option>Khảo sát</option><option>Khảo sát + lắp luôn</option></select></div>
                            <div><label class="label">Thời gian hẹn</label><input class="input" type="datetime-local" value="2026-11-11T11:30"></div>
                        </div>
                    </div>
                    <div data-panel="busy" hidden class="sm:col-span-3">
                        <div class="mt-4 grid gap-4 sm:grid-cols-2">
                            <div><label class="label">Hẹn gọi lại / lịch mới</label><input class="input" type="datetime-local" value="2026-11-12T15:00"></div>
                            <div><label class="label">Ghi chú gửi Sale</label><input class="input" placeholder="Khách đang đi công tác…"></div>
                        </div>
                        <div class="mt-3 rounded-lg bg-orange-50 p-3 text-xs text-orange-800">
                            Nhắc 2 tầng tự động: <b>trước 24h</b> – gọi chốt lịch · <b>trước 1h</b> – bắn đơn chính thức lên App Kỹ thuật.
                        </div>
                    </div>
                    <div data-panel="cancel" hidden class="sm:col-span-3">
                        <div class="mt-4"><label class="label">Lý do</label><textarea class="input" rows="2"></textarea></div>
                    </div>
                </div>
            </div>

            <div class="card overflow-hidden">
                <x-card-header title="Chọn Kỹ thuật" subtitle="Sắp xếp theo trạng thái rảnh & khoảng cách tới khách">
                    <span class="text-xs text-slate-500">SLA có mặt: 30 phút từ lúc KT nhận đơn</span>
                </x-card-header>
                <ul class="divide-y divide-slate-100">
                    @foreach (collect($technicians)->sortBy(fn ($technician) => [$technician['status'] !== 'free', (float) str_replace(',', '.', $distances[$technician['code']])]) as $technician)
                        @php($isFree = $technician['status'] === 'free')
                        <li>
                            <label @class(['flex cursor-pointer items-center gap-3 px-4 py-3 has-checked:bg-brand-50', 'opacity-60' => $technician['status'] === 'offline'])>
                                <input type="radio" name="tech" class="accent-brand-600" @checked($isFree)>
                                <x-avatar :initials="$technician['initials']" />
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-slate-900">{{ $technician['name'] }}
                                        @if ($isFree)
                                            <x-badge color="emerald" class="ml-1">Gợi ý</x-badge>
                                        @endif
                                    </p>
                                    <p class="text-xs text-slate-500">{{ $technician['area'] }} · cách {{ $distances[$technician['code']] }} · {{ $technician['jobs_today'] }} việc hôm nay</p>
                                </div>
                                <x-badge :color="$technicianStatuses[$technician['status']]['color']" dot>{{ $technicianStatuses[$technician['status']]['label'] }}</x-badge>
                            </label>
                        </li>
                    @endforeach
                </ul>
                <div class="flex flex-wrap items-center justify-end gap-2 border-t border-slate-100 p-4">
                    <button class="btn-ghost">Lưu</button>
                    <button class="btn-primary"><x-icon name="send" class="size-4" />Gán & bắn đơn lên App</button>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
