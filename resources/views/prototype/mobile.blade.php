<x-layouts.app title="App Kỹ thuật">
    <x-page-header title="App Kỹ thuật (Mobile)" subtitle="Nhận việc → check-in GPS → khảo sát & báo giá nháp → thi công & quét Serial → nghiệm thu & thu tiền · hỗ trợ Offline Mode" />

    <div class="grid justify-items-center gap-x-8 gap-y-12 md:grid-cols-2 2xl:grid-cols-3">
        {{-- 1. Job list --}}
        <x-phone caption="Danh sách việc & trạng thái Bận/Rảnh" step="Màn 1">
            <div class="bg-ink-900 px-4 pt-2 pb-5 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2.5"><x-avatar initials="LB" class="bg-white/15 text-white" /><div><p class="text-sm font-semibold">Lê Quốc Bảo</p><p class="text-[11px] text-slate-400">KT03 · Thủ Đức</p></div></div>
                    <span class="relative"><x-icon name="bell" class="size-5" /><span class="absolute -top-0.5 -right-0.5 size-2 rounded-full bg-rose-500"></span></span>
                </div>
                <div class="mt-4 flex rounded-lg bg-white/10 p-1 text-xs font-medium">
                    <span class="flex-1 rounded-md py-1.5 text-center text-slate-300">Rảnh</span>
                    <span class="flex-1 rounded-md bg-blue-500 py-1.5 text-center">Đang bận · thi công</span>
                </div>
            </div>
            <div class="-mt-3 flex-1 space-y-2.5 overflow-hidden rounded-t-2xl bg-slate-50 px-3 pt-3">
                <div class="rounded-xl border-2 border-rose-300 bg-white p-3">
                    <div class="flex items-center justify-between"><span class="rounded bg-rose-50 px-1.5 py-0.5 text-[10px] font-semibold text-rose-700">VIỆC MỚI · KHẢO SÁT</span><span class="font-mono text-[11px] font-semibold text-rose-600">⏱ 27:41</span></div>
                    <p class="mt-1.5 text-sm font-semibold text-slate-900">Cafe Mộc – Anh Khoa</p>
                    <p class="text-xs text-slate-500">45 Phan Xích Long, Phú Nhuận · 4,2 km</p>
                    <div class="mt-2.5 flex gap-2"><span class="flex-1 rounded-lg bg-slate-100 py-2 text-center text-xs font-medium text-slate-600">Từ chối</span><span class="flex-1 rounded-lg bg-brand-600 py-2 text-center text-xs font-semibold text-white">Nhận việc</span></div>
                </div>
                <p class="px-1 pt-1 text-[11px] font-semibold tracking-wider text-slate-400 uppercase">Hôm nay</p>
                @foreach ([['Nhà hàng Biển Xanh', 'Thi công · hạn 16:30', 'bg-blue-500'], ['Trường MN Hoa Sen', 'Báo giá nháp đã gửi', 'bg-violet-500'], ['Chị Lan – Sunrise', 'Chờ thu tiền', 'bg-teal-500']] as [$name, $state, $dot])
                    <div class="flex items-center gap-3 rounded-xl bg-white p-3 shadow-xs">
                        <span class="size-2 rounded-full {{ $dot }}"></span>
                        <div class="flex-1"><p class="text-sm font-medium text-slate-900">{{ $name }}</p><p class="text-xs text-slate-500">{{ $state }}</p></div>
                        <x-icon name="chevron-right" class="size-4 text-slate-300" />
                    </div>
                @endforeach
            </div>
            <div class="grid shrink-0 grid-cols-4 border-t border-slate-200 bg-white px-2 pt-2 pb-4 text-[10px] text-slate-400">
                @foreach ([['list', 'Việc', true], ['box', 'Kho', false], ['wallet', 'Ví', false], ['qr', 'Quét QR', false]] as [$icon, $label, $active])
                    <span @class(['flex flex-col items-center gap-0.5', 'text-brand-600 font-medium' => $active])><x-icon :name="$icon" class="size-5" />{{ $label }}</span>
                @endforeach
            </div>
        </x-phone>

        {{-- 2. GPS check-in --}}
        <x-phone caption="Check-in GPS trong bán kính 50m" step="Màn 2">
            <div class="flex items-center gap-2 px-4 py-2"><x-icon name="chevron-left" class="size-5" /><p class="text-sm font-semibold">Check-in · DH-2411-028</p></div>
            <div class="relative h-48 shrink-0 bg-[#e8eef1]">
                <svg class="absolute inset-0 size-full" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true"><path d="M0 30 L100 40 M0 72 L100 64 M30 0 L36 100 M72 0 L66 100" stroke="#fff" stroke-width="2.5" /></svg>
                <div class="absolute top-1/2 left-1/2 size-36 -translate-x-1/2 -translate-y-1/2 rounded-full border-2 border-dashed border-emerald-500 bg-emerald-500/10"></div>
                <span class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-full text-rose-600"><x-icon name="pin" class="size-7 fill-rose-500 stroke-white" /></span>
                <span class="absolute top-[58%] left-[56%] size-4 rounded-full border-[3px] border-white bg-blue-600 shadow ring-4 ring-blue-500/25"></span>
                <span class="absolute top-3 left-3 rounded-full bg-white px-2.5 py-1 text-[11px] font-medium shadow-sm">Geofence 50m</span>
            </div>
            <div class="flex-1 space-y-3 p-4">
                <div class="flex items-center gap-3 rounded-xl bg-emerald-50 p-3 text-emerald-800">
                    <x-icon name="check" class="size-5" />
                    <div><p class="text-sm font-semibold">Bạn đang cách khách 18m</p><p class="text-xs">Trong vùng cho phép · đến sau 24 phút</p></div>
                </div>
                <div class="rounded-xl bg-white p-3 text-xs text-slate-600 shadow-xs">
                    <p class="text-sm font-medium text-slate-900">Cafe Mộc – Anh Khoa · 0908 123 456</p>
                    <p class="mt-0.5">6 camera ngoài trời + đầu ghi 8 kênh</p>
                </div>
                <span class="block rounded-xl bg-brand-600 py-3 text-center text-sm font-semibold text-white">Bắt đầu khảo sát</span>
                <span class="block rounded-xl border border-orange-300 py-2.5 text-center text-sm font-medium text-orange-700">Khách hoãn khảo sát</span>
            </div>
        </x-phone>

        {{-- 3. Survey & draft quote (offline) --}}
        <x-phone caption="Khảo sát, upload media & báo giá nháp (Offline)" step="Màn 3" offline>
            <div class="flex items-center gap-2 px-4 py-2"><x-icon name="chevron-left" class="size-5" /><p class="text-sm font-semibold">Khảo sát · Trường MN Hoa Sen</p></div>
            <div class="flex-1 space-y-3 overflow-hidden px-4">
                <div>
                    <p class="mb-1.5 text-xs font-semibold text-slate-500">Ảnh / video hiện trường (6)</p>
                    <div class="grid grid-cols-4 gap-1.5">
                        @foreach (range(1, 6) as $index)
                            <span class="relative grid aspect-square place-items-center rounded-lg bg-gradient-to-br from-slate-200 to-slate-300"><x-icon name="image" class="size-4 text-slate-500" />
                                @if ($index > 4)<span class="absolute right-0.5 bottom-0.5 size-2 rounded-full bg-orange-500 ring-2 ring-white"></span>@endif
                            </span>
                        @endforeach
                        <span class="grid aspect-square place-items-center rounded-lg border-2 border-dashed border-slate-300 text-slate-400"><x-icon name="camera" class="size-4" /></span>
                    </div>
                </div>
                <div class="rounded-xl bg-white p-3 shadow-xs">
                    <div class="flex items-center justify-between"><p class="text-xs font-semibold text-slate-500">Báo giá nháp</p><span class="text-xs font-medium text-brand-600">+ Thêm</span></div>
                    <ul class="mt-2 space-y-2 text-xs">
                        @foreach ([['Camera IP 4MP', '10', '14.000.000'], ['Đầu ghi 8 kênh', '2', '4.800.000'], ['Ổ cứng 2TB', '2', '3.500.000'], ['Cáp Cat6 (m)', '180', '2.700.000'], ['Công lắp đặt', '1', '3.000.000']] as [$item, $quantity, $amount])
                            <li class="flex justify-between gap-2"><span class="text-slate-700">{{ $item }} <span class="text-slate-400">×{{ $quantity }}</span></span><span class="font-medium tabular-nums">{{ $amount }}</span></li>
                        @endforeach
                    </ul>
                    <div class="mt-2.5 flex justify-between border-t border-slate-100 pt-2 text-sm font-semibold"><span>Tổng nháp</span><span class="tabular-nums">27.450.000đ</span></div>
                </div>
                <textarea class="w-full rounded-xl border-0 bg-white p-3 text-xs shadow-xs" rows="2">Trần thạch cao 3.2m, đi dây trong máng có sẵn…</textarea>
            </div>
            <div class="shrink-0 p-4"><span class="block rounded-xl bg-brand-600 py-3 text-center text-sm font-semibold text-white">Gửi Kế toán (chờ có mạng)</span></div>
        </x-phone>

        {{-- 4. Install & serial --}}
        <x-phone caption="Thi công: quét Serial, phát sinh vật tư, gia hạn" step="Màn 4">
            <div class="flex items-center gap-2 px-4 py-2"><x-icon name="chevron-left" class="size-5" /><p class="text-sm font-semibold">Thi công · Nhà hàng Biển Xanh</p></div>
            <div class="flex-1 space-y-3 overflow-hidden px-4">
                <div class="grid h-28 place-items-center rounded-xl bg-ink-900 text-white">
                    <div class="text-center"><x-icon name="scan" class="mx-auto size-8 text-brand-200" /><p class="mt-1 text-xs">Quét mã vạch / Serial thiết bị</p></div>
                </div>
                <div class="rounded-xl bg-white p-3 shadow-xs">
                    <p class="text-xs font-semibold text-slate-500">Đã gắn vào đơn · 5/9</p>
                    <ul class="mt-2 space-y-1.5 font-mono text-[11px] text-slate-700">
                        @foreach (['HK4M-2611-7290', 'HK4M-2611-7291', 'HK4M-2611-7292', 'NVR8-2610-0451'] as $serial)
                            <li class="flex items-center justify-between"><span>{{ $serial }}</span><x-icon name="check" class="size-3.5 text-emerald-600" /></li>
                        @endforeach
                    </ul>
                </div>
                <div class="rounded-xl bg-white p-3 shadow-xs">
                    <p class="text-xs font-semibold text-slate-500">Phát sinh vật tư</p>
                    <div class="mt-2 grid grid-cols-2 gap-2 text-xs font-medium">
                        <span class="rounded-lg bg-emerald-50 py-2 text-center text-emerald-700">+ Thêm (tự cộng đơn)</span>
                        <span class="rounded-lg bg-rose-50 py-2 text-center text-rose-700">− Bớt (cần Admin)</span>
                    </div>
                    <p class="mt-2 text-[11px] text-amber-700">⏳ “−15m Cat6” đang chờ Admin xác nhận</p>
                </div>
            </div>
            <div class="absolute inset-x-3 bottom-3 rounded-2xl bg-white p-4 shadow-2xl ring-1 ring-slate-200">
                <p class="text-sm font-semibold text-slate-900">Còn 10 phút hết thời hạn thi công</p>
                <p class="mt-0.5 text-xs text-slate-500">Gia hạn để giữ trạng thái BẬN?</p>
                <div class="mt-3 flex gap-2 text-xs font-semibold"><span class="flex-1 rounded-lg bg-slate-100 py-2 text-center text-slate-600">Sắp xong</span><span class="flex-1 rounded-lg bg-brand-600 py-2 text-center text-white">Gia hạn 30′</span></div>
            </div>
        </x-phone>

        {{-- 5. Acceptance & cash --}}
        <x-phone caption="Nghiệm thu: ảnh, chữ ký khách & thu tiền hộ" step="Màn 5">
            <div class="flex items-center gap-2 px-4 py-2"><x-icon name="chevron-left" class="size-5" /><p class="text-sm font-semibold">Nghiệm thu · Chị Lan – Sunrise</p></div>
            <div class="flex-1 space-y-3 overflow-hidden px-4">
                <div class="grid grid-cols-3 gap-1.5">
                    @foreach (range(1, 3) as $index)
                        <span class="grid aspect-square place-items-center rounded-lg bg-gradient-to-br from-sky-100 to-slate-200"><x-icon name="image" class="size-4 text-slate-500" /></span>
                    @endforeach
                </div>
                <div class="rounded-xl bg-white p-3 shadow-xs">
                    <p class="text-xs font-semibold text-slate-500">Khách ký xác nhận</p>
                    <div class="mt-2 h-24 rounded-lg border border-dashed border-slate-300 bg-slate-50">
                        <svg viewBox="0 0 200 80" class="size-full text-ink-800" aria-hidden="true"><path d="M20 55 C 35 20, 45 70, 60 40 S 85 25, 95 50 S 120 60, 135 35 S 165 45, 180 30" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" /></svg>
                    </div>
                </div>
                <div class="rounded-xl bg-white p-3 shadow-xs">
                    <div class="flex justify-between text-xs"><span class="text-slate-500">Còn phải thu</span><span class="font-semibold">4.200.000đ</span></div>
                    <div class="mt-2 grid grid-cols-2 gap-2 text-xs font-medium">
                        <span class="rounded-lg border-2 border-brand-500 bg-brand-50 py-2 text-center text-brand-700">Tiền mặt (thu hộ)</span>
                        <span class="rounded-lg border border-slate-200 py-2 text-center text-slate-600">Khách CK cho Kế toán</span>
                    </div>
                    <input class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2 text-right text-sm font-semibold" value="4.200.000">
                </div>
            </div>
            <div class="shrink-0 p-4"><span class="block rounded-xl bg-emerald-600 py-3 text-center text-sm font-semibold text-white">Hoàn thành & bàn giao</span></div>
        </x-phone>

        {{-- 6. Wallet & mobile stock --}}
        <x-phone caption="Lợi nhuận được chia & kho di động" step="Màn 6">
            <div class="bg-ink-900 px-4 pt-2 pb-6 text-white">
                <p class="text-xs text-slate-400">Lợi nhuận được chia tháng 11</p>
                <p class="mt-1 text-2xl font-semibold tabular-nums">2.000.000đ</p>
                <div class="mt-3 grid grid-cols-2 gap-2 text-[11px]">
                    <div class="rounded-lg bg-white/10 p-2"><p class="text-slate-400">Lợi nhuận đơn tham gia</p><p class="mt-0.5 text-sm font-semibold">4,0tr</p></div>
                    <div class="rounded-lg bg-brand-500/30 p-2"><p class="text-brand-100">Tỷ lệ Kỹ thuật</p><p class="mt-0.5 text-sm font-semibold">50%</p></div>
                </div>
            </div>
            <div class="-mt-3 flex-1 space-y-3 overflow-hidden rounded-t-2xl bg-slate-50 px-4 pt-4">
                <div class="rounded-xl bg-white p-3 text-xs shadow-xs">
                    @foreach ([['DH-2411-012 · Homestay Đà Lạt', '2.000.000'], ['DH-2411-021 · đang lắp đặt', 'Chưa tính'], ['DH-2411-024 · chờ báo giá', 'Chưa tính']] as [$label, $amount])
                        <div class="flex justify-between py-1"><span class="text-slate-500">{{ $label }}</span><span class="font-medium tabular-nums">{{ $amount }}</span></div>
                    @endforeach
                    <div class="mt-1 flex justify-between border-t border-slate-100 pt-2"><span class="text-slate-500">Tiền mặt đang giữ</span><span class="font-semibold text-amber-700">12.000.000đ</span></div>
                </div>
                <div class="rounded-xl bg-white p-3 shadow-xs">
                    <p class="text-xs font-semibold text-slate-500">Kho di động</p>
                    <ul class="mt-2 space-y-1.5 text-xs">
                        @foreach ([['Camera IP 4MP', 6], ['Đầu ghi 8 kênh', 2], ['Ổ cứng 2TB', 2], ['Cáp Cat6', '320m'], ['Camera Wi-Fi', 0]] as [$item, $quantity])
                            <li class="flex justify-between"><span class="text-slate-700">{{ $item }}</span><span @class(['font-semibold tabular-nums', 'text-rose-600' => $quantity === 0])>{{ $quantity }}</span></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="grid shrink-0 grid-cols-4 border-t border-slate-200 bg-white px-2 pt-2 pb-4 text-[10px] text-slate-400">
                @foreach ([['list', 'Việc', false], ['box', 'Kho', false], ['wallet', 'Ví', true], ['qr', 'Quét QR', false]] as [$icon, $label, $active])
                    <span @class(['flex flex-col items-center gap-0.5', 'text-brand-600 font-medium' => $active])><x-icon :name="$icon" class="size-5" />{{ $label }}</span>
                @endforeach
            </div>
        </x-phone>
    </div>
</x-layouts.app>
