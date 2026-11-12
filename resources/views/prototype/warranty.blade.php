<x-layouts.app title="Bảo hành & Serial">
    <x-page-header title="Bảo hành & tra cứu Serial" subtitle="Quét QR bảo hành trên thiết bị để xem toàn bộ lịch sử · tạo phiếu sự cố gắn đơn cũ">
        <x-slot:actions>
            <button class="btn-primary" data-open="ticket"><x-icon name="plus" class="size-4" />Tạo phiếu bảo hành</button>
        </x-slot:actions>
    </x-page-header>

    <div class="grid gap-6 lg:grid-cols-[1fr_1.2fr]">
        <div class="space-y-4">
            <div class="card p-5">
                <label class="label" for="serial">Serial / mã QR</label>
                <div class="flex gap-2">
                    <input id="serial" class="input font-mono" value="HK4M-2611-7301">
                    <button class="btn-ghost shrink-0"><x-icon name="scan" class="size-4" />Quét</button>
                </div>
            </div>

            <div class="card overflow-hidden">
                <div class="flex items-center gap-4 border-b border-slate-100 p-5">
                    <div class="grid size-20 shrink-0 grid-cols-5 gap-0.5 rounded-lg bg-white p-1.5 ring-1 ring-slate-200">
                        @foreach ([1,1,1,0,1, 1,0,1,1,0, 1,1,0,1,1, 0,1,1,0,1, 1,0,1,1,1] as $cell)
                            <span class="{{ $cell ? 'bg-ink-900' : '' }} rounded-[1px]"></span>
                        @endforeach
                    </div>
                    <div>
                        <p class="font-semibold text-slate-900">Camera IP 4MP ngoài trời</p>
                        <p class="font-mono text-sm text-slate-500">HK4M-2611-7301</p>
                        <x-badge color="emerald" dot class="mt-1.5">Còn bảo hành · 346 ngày</x-badge>
                    </div>
                </div>
                <dl class="grid grid-cols-2 gap-4 p-5 text-sm">
                    <div><dt class="text-xs text-slate-500">Đơn hàng</dt><dd class="font-mono font-medium text-brand-700">DH-2411-024</dd></div>
                    <div><dt class="text-xs text-slate-500">Khách hàng</dt><dd class="font-medium">Trường MN Hoa Sen</dd></div>
                    <div><dt class="text-xs text-slate-500">Ngày lắp</dt><dd>11/11/2026</dd></div>
                    <div><dt class="text-xs text-slate-500">Người lắp</dt><dd>Lê Quốc Bảo (KT03)</dd></div>
                    <div><dt class="text-xs text-slate-500">BH công ty (QR)</dt><dd>đến 11/11/2027</dd></div>
                    <div><dt class="text-xs text-slate-500">BH hãng</dt><dd>đến 11/11/2028</dd></div>
                    <div class="col-span-2"><dt class="text-xs text-slate-500">Vị trí</dt><dd>Lớp Mầm 1 · góc trần cửa ra vào</dd></div>
                </dl>
            </div>
        </div>

        <div class="card overflow-hidden">
            <x-card-header title="Phiếu bảo hành / sự cố" subtitle="Tự động phân công lại Kỹ thuật cũ" />
            <ul class="divide-y divide-slate-100">
                @foreach ([
                    ['BH-0112', 'Anh Phong – Biệt thự', 'Camera cổng mất hình ban đêm', 'DH-2410-102', 'Phạm Đức Long', 'fuchsia', 'Đang bảo hành'],
                    ['BH-0111', 'Spa Ngọc Lan', 'Không xem được trên điện thoại', 'DH-2411-014', 'Nguyễn Văn Hùng', 'amber', 'Chờ KT nhận'],
                    ['BH-0108', 'Văn phòng Luật Tâm An', 'Ổ cứng báo lỗi', 'DH-2411-016', 'Phạm Đức Long', 'emerald', 'Đã xử lý'],
                ] as [$code, $customer, $issue, $order, $tech, $color, $state])
                    <li class="flex items-start gap-3 px-4 py-4">
                        <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-fuchsia-50 text-fuchsia-700"><x-icon name="shield" class="size-4" /></span>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium text-slate-900">{{ $issue }}</p>
                            <p class="text-xs text-slate-500">{{ $customer }} · <span class="font-mono">{{ $code }}</span> ← <span class="font-mono">{{ $order }}</span></p>
                            <p class="mt-1 text-xs text-slate-500">KT cũ: {{ $tech }}</p>
                        </div>
                        <x-badge :color="$color" dot>{{ $state }}</x-badge>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <dialog id="ticket" class="m-auto w-full max-w-md rounded-2xl p-0 shadow-2xl backdrop:bg-slate-900/40">
        <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
            <h2 class="font-semibold">Tạo phiếu bảo hành / sự cố</h2>
            <button data-close class="rounded-md p-1.5 hover:bg-slate-100"><x-icon name="x" class="size-4" /></button>
        </div>
        <div class="space-y-4 p-5">
            <div><label class="label">Mã đơn cũ hoặc Serial</label><input class="input font-mono" value="DH-2411-014"></div>
            <div><label class="label">Mô tả sự cố</label><textarea class="input" rows="3"></textarea></div>
            <div class="rounded-lg bg-brand-50 p-3 text-xs text-brand-700">Đơn sẽ chuyển ĐANG_BẢO_HÀNH và tự gán lại KT cũ <b>Nguyễn Văn Hùng</b>.</div>
        </div>
        <div class="flex justify-end gap-2 border-t border-slate-100 px-5 py-3">
            <button data-close class="btn-ghost">Hủy</button>
            <button data-close class="btn-primary">Tạo phiếu</button>
        </div>
    </dialog>
</x-layouts.app>
