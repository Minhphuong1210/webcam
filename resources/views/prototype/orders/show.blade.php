@php
    use App\Support\DemoData;

    $currentStep = $statuses[$order['status']]['step'];
    $steps = [
        ['label' => 'Tạo lead & xác minh', 'by' => $order['sale'].' → Thu Trang', 'time' => '08:56'],
        ['label' => 'Gán KT & khảo sát GPS', 'by' => $order['tech'] ?? '—', 'time' => '09:21'],
        ['label' => 'Thẩm định & chốt báo giá', 'by' => 'Thu Trang', 'time' => '10:02'],
        ['label' => 'Thi công & quét Serial', 'by' => $order['tech'] ?? '—', 'time' => '—'],
        ['label' => 'Nghiệm thu & thu tiền', 'by' => 'Kế toán', 'time' => '—'],
        ['label' => 'Tính & chia lợi nhuận', 'by' => 'Kế toán', 'time' => '—'],
    ];
    $subtotal = collect($lines)->sum(fn ($line) => $line['qty'] * $line['std_price']);
    $materialCost = collect($lines)->sum(fn ($line) => $line['qty'] * $line['cost']);
@endphp

<x-layouts.app :title="$order['code']">
    <nav class="mb-3 flex items-center gap-1 text-sm text-slate-500">
        <a href="{{ route('orders.index') }}" class="hover:text-slate-800">Đơn hàng</a>
        <x-icon name="chevron-right" class="size-4" />
        <span class="font-mono text-slate-800">{{ $order['code'] }}</span>
    </nav>

    <x-page-header :title="$order['customer']">
        <x-slot:actions>
            <button class="btn-ghost"><x-icon name="call" class="size-4" />Gọi khách</button>
            <button class="btn-ghost"><x-icon name="shield" class="size-4" />Tạo phiếu bảo hành</button>
            <a href="{{ route('quotes.show', 'DH-2411-024') }}" class="btn-primary"><x-icon name="file" class="size-4" />Mở báo giá</a>
        </x-slot:actions>
    </x-page-header>

    <div class="-mt-4 mb-6 flex flex-wrap items-center gap-2">
        <x-status :status="$order['status']" />
        <x-sla :sla="$order['sla']" />
        @if ($order['priority'])
            <x-badge color="amber"><x-icon name="flag" class="size-3" />ƯU TIÊN · KT cũ</x-badge>
        @endif
    </div>

    {{-- Stepper --}}
    <div class="card mb-6 overflow-x-auto p-4">
        <ol class="flex min-w-[820px] items-start">
            @foreach ($steps as $index => $step)
                @php($number = $index + 1)
                <li class="flex flex-1 flex-col items-center text-center">
                    <div class="flex w-full items-center">
                        <span @class(['h-0.5 flex-1', 'bg-brand-500' => $number <= $currentStep, 'bg-slate-200' => $number > $currentStep, 'invisible' => $number === 1])></span>
                        <span @class([
                            'grid size-8 shrink-0 place-items-center rounded-full text-xs font-semibold',
                            'bg-brand-600 text-white' => $number < $currentStep,
                            'bg-white text-brand-700 ring-2 ring-brand-500' => $number === $currentStep,
                            'bg-slate-100 text-slate-400' => $number > $currentStep,
                        ])>
                            @if ($number < $currentStep)
                                <x-icon name="check" class="size-4" />
                            @else
                                {{ $number }}
                            @endif
                        </span>
                        <span @class(['h-0.5 flex-1', 'bg-brand-500' => $number < $currentStep, 'bg-slate-200' => $number >= $currentStep, 'invisible' => $number === 6])></span>
                    </div>
                    <p @class(['mt-2 px-2 text-xs font-medium', 'text-slate-900' => $number <= $currentStep, 'text-slate-400' => $number > $currentStep])>{{ $step['label'] }}</p>
                    <p class="text-[11px] text-slate-400">{{ $number <= $currentStep ? $step['by'].' · '.$step['time'] : 'Chưa tới' }}</p>
                </li>
            @endforeach
        </ol>
    </div>

    <div class="grid gap-6 lg:grid-cols-[1fr_360px]">
        <div class="space-y-6" data-tabs>
            <div class="flex gap-1 border-b border-slate-200">
                @foreach (['survey' => 'Khảo sát & media', 'quote' => 'Báo giá', 'serial' => 'Thiết bị & Serial', 'audit' => 'Lịch sử thay đổi'] as $key => $label)
                    <button data-tab="{{ $key }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}" class="-mb-px border-b-2 border-transparent px-3 py-2 text-sm font-medium text-slate-500 hover:text-slate-800 aria-selected:border-brand-600 aria-selected:text-brand-700">{{ $label }}</button>
                @endforeach
            </div>

            <div data-panel="survey" class="space-y-4">
                <div class="card p-4">
                    <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-sm">
                        <span class="flex items-center gap-1.5 text-emerald-700"><x-icon name="pin" class="size-4" />Check-in hợp lệ · cách 18m</span>
                        <span class="text-slate-500">09:21:04 · 10.8012, 106.7109</span>
                        <span class="text-slate-500">Thời gian có mặt: <b class="text-slate-800">24 phút</b> (SLA 30′)</span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
                    @foreach (['Cổng chính', 'Sảnh lớp A', 'Hành lang tầng 2', 'Tủ rack'] as $index => $caption)
                        <figure class="overflow-hidden rounded-xl border border-slate-200 bg-white">
                            <div class="grid aspect-4/3 place-items-center bg-gradient-to-br {{ ['from-slate-200 to-slate-300', 'from-sky-100 to-slate-200', 'from-amber-50 to-slate-200', 'from-slate-300 to-slate-400'][$index] }}">
                                <x-icon :name="$index === 2 ? 'camera' : 'image'" class="size-7 text-slate-500/70" />
                            </div>
                            <figcaption class="px-2.5 py-2 text-xs"><p class="font-medium text-slate-800">{{ $caption }}</p><p class="text-slate-400">{{ $index === 2 ? 'Video 0:42' : 'Ảnh' }} · 09:3{{ $index }}</p></figcaption>
                        </figure>
                    @endforeach
                </div>
                <div class="card p-4 text-sm">
                    <p class="font-medium text-slate-900">Ghi chú khảo sát của Kỹ thuật</p>
                    <p class="mt-1 text-slate-600">10 lớp học, trần thạch cao cao 3.2m. Đi dây trong máng có sẵn, tủ rack đặt phòng hiệu phó. Khách muốn lưu 30 ngày → 2 đầu ghi + 2 ổ 2TB. Đường truyền mạng ổn định, có sẵn modem quang.</p>
                </div>
            </div>

            <div data-panel="quote" hidden class="card overflow-hidden">
                <table class="table-base">
                    <thead><tr><th>Hạng mục</th><th class="text-right">SL</th><th class="text-right">Đơn giá</th><th class="text-right">Thành tiền</th></tr></thead>
                    <tbody>
                        @foreach ($lines as $line)
                            <tr>
                                <td><p class="font-medium text-slate-900">{{ $line['name'] }}</p><p class="font-mono text-xs text-slate-400">{{ $line['code'] }}</p></td>
                                <td class="text-right tabular-nums">{{ $line['qty'] }}</td>
                                <td class="text-right tabular-nums">{{ DemoData::money($line['std_price']) }}</td>
                                <td class="text-right font-medium tabular-nums">{{ DemoData::money($line['qty'] * $line['std_price']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot><tr><td colspan="3" class="px-4 py-3 text-right font-medium">Tổng báo giá</td><td class="px-4 py-3 text-right text-base font-semibold tabular-nums">{{ DemoData::money($subtotal) }}</td></tr></tfoot>
                </table>
            </div>

            <div data-panel="serial" hidden class="card overflow-hidden">
                <table class="table-base">
                    <thead><tr><th>Thiết bị</th><th>Serial</th><th>Vị trí lắp</th><th>Bảo hành đến</th><th>QR</th></tr></thead>
                    <tbody>
                        @foreach (['Lớp Mầm 1', 'Lớp Mầm 2', 'Lớp Chồi 1', 'Sảnh'] as $index => $place)
                            <tr>
                                <td>Camera IP 4MP</td>
                                <td class="font-mono text-xs">HK4M-2611-{{ 7301 + $index }}</td>
                                <td>{{ $place }}</td>
                                <td>11/11/2027</td>
                                <td><button class="inline-flex items-center gap-1 text-xs font-medium text-brand-700"><x-icon name="qr" class="size-4" />In tem</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div data-panel="audit" hidden class="card">
                <ol class="relative space-y-5 p-5 before:absolute before:top-6 before:bottom-6 before:left-[29px] before:w-px before:bg-slate-200">
                    @foreach ($auditLogs as $log)
                        <li class="relative flex gap-4">
                            <span class="z-10 grid size-5 shrink-0 place-items-center rounded-full bg-white ring-2 ring-brand-500"><span class="size-1.5 rounded-full bg-brand-500"></span></span>
                            <div class="text-sm">
                                <p class="font-medium text-slate-900">{{ $log['action'] }} <span class="font-normal text-slate-500">· {{ $log['user'] }}</span></p>
                                <p class="mt-0.5 text-slate-600"><span class="line-through decoration-slate-400">{{ $log['before'] }}</span> → <b>{{ $log['after'] }}</b> <span class="text-slate-400">({{ $log['diff'] }})</span></p>
                                <p class="text-xs text-slate-400">{{ $log['time'] }} · Lý do: {{ $log['reason'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>

        <aside class="space-y-4">
            <div class="card p-4">
                <h3 class="text-sm font-semibold text-slate-900">Thông tin khách hàng</h3>
                <dl class="mt-3 space-y-2.5 text-sm">
                    <div class="flex gap-2"><x-icon name="call" class="mt-0.5 size-4 shrink-0 text-slate-400" /><dd>{{ $order['phone'] }}</dd></div>
                    <div class="flex gap-2"><x-icon name="pin" class="mt-0.5 size-4 shrink-0 text-slate-400" /><dd>{{ $order['address'] }}</dd></div>
                    <div class="flex gap-2"><x-icon name="camera" class="mt-0.5 size-4 shrink-0 text-slate-400" /><dd>{{ $order['need'] }}</dd></div>
                </dl>
            </div>

            <div class="card p-4">
                <h3 class="text-sm font-semibold text-slate-900">Phụ trách</h3>
                <ul class="mt-3 space-y-3 text-sm">
                    <li class="flex items-center gap-3"><x-avatar :initials="DemoData::initials($order['sale'])" /><div><p class="font-medium">{{ $order['sale'] }}</p><p class="text-xs text-slate-500">Sale</p></div></li>
                    <li class="flex items-center gap-3"><x-avatar initials="TT" /><div><p class="font-medium">Thu Trang</p><p class="text-xs text-slate-500">Kế toán điều phối</p></div></li>
                    @if ($order['tech'])
                        <li class="flex items-center gap-3"><x-avatar :initials="DemoData::initials($order['tech'])" /><div><p class="font-medium">{{ $order['tech'] }}</p><p class="text-xs text-slate-500">Kỹ thuật</p></div></li>
                    @endif
                </ul>
            </div>

            <div class="card p-4">
                <h3 class="text-sm font-semibold text-slate-900">Tài chính đơn hàng</h3>
                <dl class="mt-3 space-y-2 text-sm">
                    <div class="flex justify-between"><dt class="text-slate-500">Tổng báo giá</dt><dd class="font-medium tabular-nums">{{ DemoData::money($subtotal) }}</dd></div>
                    <div class="flex justify-between"><dt class="text-slate-500">Đã cọc (CK)</dt><dd class="tabular-nums">{{ DemoData::money(8000000) }}</dd></div>
                    <div class="flex justify-between"><dt class="text-slate-500">Còn phải thu</dt><dd class="font-semibold text-amber-700 tabular-nums">{{ DemoData::money($subtotal - 8000000) }}</dd></div>
                    <div class="my-2 border-t border-dashed border-slate-200"></div>
                    <div class="flex justify-between"><dt class="text-slate-500">Chi phí vật tư (dự kiến)</dt><dd class="tabular-nums">−{{ DemoData::money($materialCost) }}</dd></div>
                    <div class="flex justify-between"><dt class="text-slate-500">Phát sinh do Kỹ thuật báo</dt><dd class="tabular-nums">—</dd></div>
                    <div class="flex justify-between"><dt class="font-medium text-slate-900">Lợi nhuận dự kiến</dt><dd class="font-semibold text-emerald-700 tabular-nums">{{ DemoData::money($subtotal - $materialCost) }}</dd></div>
                </dl>
                <div class="mt-3 grid grid-cols-2 gap-2 text-xs">
                    @foreach ($profitSplit as $split)
                        <div class="rounded-lg bg-slate-50 px-2.5 py-2">
                            <p class="text-slate-500">{{ $split['label'] }} {{ $split['percent'] }}%</p>
                            <p class="mt-0.5 font-semibold text-slate-900 tabular-nums">{{ DemoData::money((int) round(($subtotal - $materialCost) * $split['percent'] / 100)) }}</p>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('allocations') }}" class="btn-ghost mt-4 w-full"><x-icon name="sliders" class="size-4" />Chi phí & lợi nhuận</a>
            </div>
        </aside>
    </div>
</x-layouts.app>
