@php
    use App\Support\DemoData;

    $draftTotal = collect($lines)->sum(fn ($line) => $line['qty'] * $line['draft_price']);
    $standardTotal = collect($lines)->sum(fn ($line) => $line['qty'] * $line['std_price']);
    $materialCost = collect($lines)->sum(fn ($line) => $line['qty'] * $line['cost']);
    $margin = $standardTotal - $materialCost;
@endphp

<x-layouts.app title="Thẩm định báo giá">
    <nav class="mb-3 flex items-center gap-1 text-sm text-slate-500">
        <a href="{{ route('dispatch') }}" class="hover:text-slate-800">Điều phối</a>
        <x-icon name="chevron-right" class="size-4" />
        <span>Báo giá</span>
        <x-icon name="chevron-right" class="size-4" />
        <span class="font-mono text-slate-800">{{ $order['code'] }}</span>
    </nav>

    <x-page-header title="Thẩm định báo giá · {{ $order['customer'] }}" subtitle="Báo giá nháp từ KT {{ $order['tech'] }} (tạo offline, đồng bộ 09:58) · áp chuẩn bảng giá công ty">
        <x-slot:actions>
            <span class="inline-flex items-center gap-1.5 rounded-lg bg-amber-50 px-3 py-2 text-sm font-medium text-amber-800 ring-1 ring-amber-200"><x-icon name="clock" class="size-4" />SLA lên báo giá: còn 04:12</span>
        </x-slot:actions>
    </x-page-header>

    <div class="grid gap-6 lg:grid-cols-[1fr_340px]">
        <div class="card overflow-hidden">
            <x-card-header title="Hạng mục báo giá" subtitle="Ô vàng = đơn giá nháp khác bảng giá chuẩn">
                <button class="btn-ghost py-1.5 text-xs"><x-icon name="plus" class="size-3.5" />Thêm hạng mục</button>
            </x-card-header>
            <div class="overflow-x-auto">
                <table class="table-base min-w-[860px]">
                    <thead>
                        <tr><th>Hạng mục</th><th class="text-right">SL</th><th class="text-right">Giá nháp KT</th><th class="text-right">Giá chuẩn</th><th class="text-right">Đơn giá chốt</th><th class="text-right">Thành tiền</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($lines as $line)
                            @php($isDifferent = $line['draft_price'] !== $line['std_price'])
                            <tr>
                                <td class="min-w-60"><p class="font-medium text-slate-900">{{ $line['name'] }}</p><p class="font-mono text-xs text-slate-400">{{ $line['code'] }}</p></td>
                                <td class="text-right"><input class="input w-20 text-right tabular-nums" value="{{ $line['qty'] }}"></td>
                                <td @class(['text-right tabular-nums', 'text-amber-700' => $isDifferent])>{{ DemoData::money($line['draft_price']) }}</td>
                                <td class="text-right text-slate-500 tabular-nums">{{ DemoData::money($line['std_price']) }}</td>
                                <td class="text-right"><input @class(['input w-32 text-right tabular-nums', 'border-amber-400 bg-amber-50' => $isDifferent]) value="{{ number_format($line['std_price'], 0, ',', '.') }}"></td>
                                <td class="text-right font-medium tabular-nums">{{ DemoData::money($line['qty'] * $line['std_price']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="border-t border-slate-100 p-4">
                <label class="label" for="reason">Lý do chỉnh sửa (ghi vào Audit Log) <span class="text-rose-500">*</span></label>
                <input id="reason" class="input" value="Áp bảng giá chuẩn công ty cho camera & hộp kỹ thuật">
            </div>
        </div>

        <aside class="space-y-4">
            <div class="card p-5">
                <h3 class="text-sm font-semibold text-slate-900">Tổng hợp</h3>
                <dl class="mt-4 space-y-2.5 text-sm">
                    <div class="flex justify-between"><dt class="text-slate-500">Báo giá nháp KT</dt><dd class="tabular-nums">{{ DemoData::money($draftTotal) }}</dd></div>
                    <div class="flex justify-between"><dt class="text-slate-500">Chênh lệch sau thẩm định</dt><dd class="text-emerald-700 tabular-nums">+{{ DemoData::money($standardTotal - $draftTotal) }}</dd></div>
                    <div class="flex justify-between border-t border-slate-100 pt-2.5"><dt class="font-medium text-slate-900">Tổng báo giá chốt</dt><dd class="text-lg font-semibold tabular-nums">{{ DemoData::money($standardTotal) }}</dd></div>
                    <div class="flex justify-between"><dt class="text-slate-500">Giá vốn vật tư dự kiến</dt><dd class="tabular-nums">{{ DemoData::money($materialCost) }}</dd></div>
                    <div class="flex justify-between"><dt class="text-slate-500">Lợi nhuận gộp dự kiến</dt><dd class="font-medium text-emerald-700 tabular-nums">{{ DemoData::money($margin) }} · {{ round($margin / $standardTotal * 100) }}%</dd></div>
                </dl>
                <div class="mt-4"><label class="label" for="deposit">Tiền cọc yêu cầu</label><input id="deposit" class="input" value="8.000.000"></div>
            </div>

            <div class="space-y-2">
                <button class="btn-primary w-full py-2.5"><x-icon name="download" class="size-4" />Chốt & xuất PDF gửi khách</button>
                <button class="btn-ghost w-full"><x-icon name="check" class="size-4" />Khách đồng ý → Đang thi công</button>
                <button class="btn-danger w-full" data-open="escalate"><x-icon name="alert" class="size-4" />Khách chê đắt · Cần Admin</button>
            </div>

            <div class="card p-4 text-xs text-slate-500">
                <p class="font-medium text-slate-700">Lịch sử phiên bản</p>
                <ul class="mt-2 space-y-1.5">
                    <li>v1 · KT Lê Quốc Bảo · 09:58 · {{ DemoData::money($draftTotal) }}</li>
                    <li class="font-medium text-slate-800">v2 · Kế toán Thu Trang · đang sửa</li>
                </ul>
            </div>
        </aside>
    </div>

    <dialog id="escalate" class="m-auto w-full max-w-md rounded-2xl p-0 shadow-2xl backdrop:bg-slate-900/40">
        <div class="border-b border-rose-100 bg-rose-50 px-5 py-4">
            <p class="flex items-center gap-2 font-semibold text-rose-900"><x-icon name="alert" class="size-5" />Gửi BÁO ĐỘNG ĐỎ cho Admin</p>
            <p class="mt-1 text-sm text-rose-700">Admin nhận push ngay lập tức · SLA duyệt &lt; 60 phút</p>
        </div>
        <div class="space-y-4 p-5">
            <div><label class="label">Giá khách mong muốn</label><input class="input" placeholder="VD: 30.000.000"></div>
            <div><label class="label">Đề xuất</label>
                <select class="input"><option>Giảm giá ngoại lệ</option><option>Tặng kèm dịch vụ (lưu cloud, bảo trì)</option><option>Đổi thiết bị tương đương rẻ hơn</option></select>
            </div>
            <div><label class="label">Ghi chú</label><textarea class="input" rows="2" placeholder="Khách so sánh giá với đơn vị khác…"></textarea></div>
        </div>
        <div class="flex justify-end gap-2 border-t border-slate-100 px-5 py-3">
            <button data-close class="btn-ghost">Hủy</button>
            <button data-close class="btn-danger">Gửi Admin</button>
        </div>
    </dialog>
</x-layouts.app>
