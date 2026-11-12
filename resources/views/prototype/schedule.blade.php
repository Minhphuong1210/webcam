@php
    use App\Support\DemoData;

    $days = ['T2 09/11', 'T3 10/11', 'T4 11/11', 'T5 12/11', 'T6 13/11', 'T7 14/11', 'CN 15/11'];
    $today = 2;
    $types = [
        'survey' => ['label' => 'Khảo sát', 'class' => 'border-sky-200 bg-sky-50 text-sky-900'],
        'install' => ['label' => 'Lắp đặt', 'class' => 'border-brand-200 bg-brand-50 text-brand-700'],
    ];
    $states = [
        'done' => ['label' => 'Hoàn thành', 'color' => 'emerald'],
        'in_progress' => ['label' => 'Đang làm', 'color' => 'blue'],
        'planned' => ['label' => 'Đã hẹn', 'color' => 'slate'],
        'late' => ['label' => 'Trễ hẹn', 'color' => 'rose'],
        'pending' => ['label' => 'Chờ khách xác nhận', 'color' => 'amber'],
    ];
    $byTechnician = collect($appointments)->groupBy('tech');
    $upcoming = collect($appointments)->filter(fn ($item) => $item['day'] >= $today && $item['state'] !== 'done')->sortBy(['day', 'time'])->values();
@endphp

<x-layouts.app title="Lịch triển khai">
    <x-page-header title="Lịch triển khai" subtitle="Khi khách chốt báo giá: hẹn lịch lắp đặt và phân công Kỹ thuật · tuần 09/11 – 15/11/2026">
        <x-slot:actions>
            <div class="flex items-center gap-1">
                <button class="btn-ghost px-2.5"><x-icon name="chevron-left" class="size-4" /></button>
                <button class="btn-ghost">Tuần này</button>
                <button class="btn-ghost px-2.5"><x-icon name="chevron-right" class="size-4" /></button>
            </div>
            <button class="btn-primary" data-open="appointment"><x-icon name="plus" class="size-4" />Hẹn lịch lắp đặt</button>
        </x-slot:actions>
    </x-page-header>

    <div class="mb-4 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-slate-600">
        @foreach ($types as $type)
            <span class="flex items-center gap-1.5"><span class="size-3 rounded border {{ $type['class'] }}"></span>{{ $type['label'] }}</span>
        @endforeach
        <span class="text-slate-300">|</span>
        @foreach ($states as $state)
            <x-badge :color="$state['color']" dot>{{ $state['label'] }}</x-badge>
        @endforeach
    </div>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1240px] table-fixed border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="w-52 border-b border-slate-200 px-4 py-2.5 text-left text-xs font-semibold tracking-wide text-slate-500 uppercase">Kỹ thuật</th>
                        @foreach ($days as $index => $day)
                            <th @class([
                                'border-b border-l border-slate-200 px-3 py-2.5 text-left text-xs font-semibold whitespace-nowrap',
                                'bg-brand-50 text-brand-700' => $index === $today,
                                'text-slate-500' => $index !== $today,
                            ])>{{ $day }} @if ($index === $today)<span class="ml-1 rounded bg-brand-600 px-1.5 py-0.5 text-[10px] text-white">Hôm nay</span>@endif</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($technicians as $technician)
                        <tr class="align-top">
                            <td class="border-b border-slate-100 px-4 py-3">
                                <div class="flex items-center gap-2.5">
                                    <x-avatar :initials="$technician['initials']" />
                                    <div class="min-w-0">
                                        <p class="truncate font-medium text-slate-900">{{ $technician['name'] }}</p>
                                        <p class="text-xs text-slate-500">{{ $technician['code'] }} · {{ $technician['area'] }}</p>
                                    </div>
                                </div>
                                <x-badge :color="$technicianStatuses[$technician['status']]['color']" dot class="mt-2">{{ $technicianStatuses[$technician['status']]['label'] }}</x-badge>
                            </td>
                            @foreach ($days as $index => $day)
                                <td @class(['h-28 border-b border-l border-slate-100 p-1.5', 'bg-brand-50/40' => $index === $today])>
                                    <div class="space-y-1.5">
                                        @foreach (($byTechnician[$technician['code']] ?? collect())->where('day', $index)->sortBy('time') as $item)
                                            <a href="{{ DemoData::order($item['order']) ? route('orders.show', $item['order']) : '#' }}" class="block rounded-md border px-2 py-1.5 transition hover:shadow-sm {{ $types[$item['type']]['class'] }}">
                                                <p class="flex items-center justify-between gap-1 text-[11px] font-semibold">
                                                    <span class="truncate">{{ $item['time'] }} · {{ $types[$item['type']]['label'] }}</span>
                                                    @if ($item['state'] === 'late')
                                                        <x-icon name="alert" class="size-3.5 shrink-0 text-rose-600" />
                                                    @elseif ($item['state'] === 'done')
                                                        <x-icon name="check" class="size-3.5 shrink-0 text-emerald-600" />
                                                    @endif
                                                </p>
                                                <p class="mt-0.5 truncate text-xs text-slate-700">{{ $item['customer'] }}</p>
                                            </a>
                                        @endforeach
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mt-6 overflow-hidden">
        <x-card-header title="Lịch hẹn sắp tới" subtitle="Từ hôm nay · nhắc Kỹ thuật qua App trước giờ hẹn">
            <x-badge color="brand">{{ $upcoming->count() }} lịch</x-badge>
        </x-card-header>
        <ul class="divide-y divide-slate-100">
            @foreach ($upcoming as $item)
                @php($technician = collect($technicians)->firstWhere('code', $item['tech']))
                <li class="flex flex-wrap items-center gap-x-4 gap-y-2 px-4 py-3">
                    <div class="w-28 shrink-0">
                        <p class="text-sm font-semibold text-slate-900 tabular-nums">{{ $item['time'] }}</p>
                        <p class="text-xs text-slate-500">{{ $days[$item['day']] }}</p>
                    </div>
                    <div class="min-w-48 flex-1">
                        <p class="font-medium text-slate-900">{{ $item['customer'] }}</p>
                        <p class="text-xs text-slate-500"><span class="font-mono">{{ $item['order'] }}</span> · {{ $types[$item['type']]['label'] }}</p>
                    </div>
                    <div class="flex w-48 items-center gap-2">
                        <x-avatar :initials="$technician['initials']" size="size-7" class="text-[10px]" />
                        <span class="truncate text-sm text-slate-700">{{ $technician['name'] }}</span>
                    </div>
                    <x-badge :color="$states[$item['state']]['color']" dot>{{ $states[$item['state']]['label'] }}</x-badge>
                    <button class="btn-ghost ml-auto px-2.5 py-1 text-xs">Đổi lịch</button>
                </li>
            @endforeach
        </ul>
    </div>

    <dialog id="appointment" class="m-auto w-full max-w-lg rounded-2xl p-0 shadow-2xl backdrop:bg-slate-900/40">
        <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
            <div>
                <h2 class="font-semibold">Hẹn lịch lắp đặt</h2>
                <p class="text-xs text-slate-500">Áp dụng cho đơn khách đã chốt báo giá</p>
            </div>
            <button data-close class="rounded-md p-1.5 hover:bg-slate-100"><x-icon name="x" class="size-4" /></button>
        </div>
        <div class="space-y-4 p-5">
            <div>
                <label class="label">Đơn hàng</label>
                <select class="input"><option>DH-2411-024 · Trường MN Hoa Sen · 29.700.000đ</option><option>DH-2411-023 · Chú Tư – Nhà vườn · 19.800.000đ</option></select>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div><label class="label">Ngày lắp đặt</label><input type="date" class="input" value="2026-11-12"></div>
                <div><label class="label">Giờ bắt đầu</label><input type="time" class="input" value="08:30"></div>
            </div>
            <div>
                <label class="label">Phân công Kỹ thuật</label>
                <select class="input">
                    @foreach ($technicians as $technician)
                        <option @selected($technician['code'] === 'KT03')>{{ $technician['name'] }} · {{ $technicianStatuses[$technician['status']]['label'] }}</option>
                    @endforeach
                </select>
            </div>
            <div><label class="label">Ghi chú cho Kỹ thuật</label><textarea class="input" rows="3">Lắp 10 camera lớp học. Liên hệ cô Hiệu phó trước 30 phút. Mang theo thang 3m.</textarea></div>
            <label class="flex items-center gap-2 text-sm text-slate-700"><input type="checkbox" checked class="rounded border-slate-300 text-brand-600"> Gửi thông báo cho Kỹ thuật qua App</label>
        </div>
        <div class="flex justify-end gap-2 border-t border-slate-100 px-5 py-3">
            <button data-close class="btn-ghost">Hủy</button>
            <button data-close class="btn-primary"><x-icon name="send" class="size-4" />Lưu & gửi lịch</button>
        </div>
    </dialog>
</x-layouts.app>
