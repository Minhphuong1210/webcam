<x-layouts.app title="Tạo lead">
    <x-page-header title="Tạo lead mới" subtitle="Nhập thông tin sơ bộ · đơn sẽ chuyển sang trạng thái CHỜ XÁC NHẬN và đẩy cho Kế toán" />

    <form class="grid gap-6 lg:grid-cols-[1fr_320px]" onsubmit="event.preventDefault(); document.getElementById('lead-created').showModal()">
        <div class="space-y-6">
            <section class="card p-5">
                <h2 class="text-sm font-semibold text-slate-900">Khách hàng</h2>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="label" for="phone">Số điện thoại <span class="text-rose-500">*</span></label>
                        <input id="phone" class="input" placeholder="0909 123 456" required>
                        <p class="mt-1 text-xs text-slate-500">Hệ thống tự kiểm tra khách cũ & lịch sử bảo hành.</p>
                    </div>
                    <div>
                        <label class="label" for="name">Tên khách hàng <span class="text-rose-500">*</span></label>
                        <input id="name" class="input" placeholder="Anh/Chị … hoặc tên công ty" required>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="label" for="address">Địa chỉ thi công chi tiết <span class="text-rose-500">*</span></label>
                        <input id="address" class="input" placeholder="Số nhà, đường, phường, quận" required>
                        <p class="mt-1 flex items-center gap-1 text-xs text-slate-500"><x-icon name="pin" class="size-3.5" />Địa chỉ dùng làm tâm geofence 50m cho Kỹ thuật check-in.</p>
                    </div>
                </div>
            </section>

            <section class="card p-5">
                <h2 class="text-sm font-semibold text-slate-900">Nhu cầu lắp đặt</h2>
                <div class="mt-4 grid gap-4 sm:grid-cols-3">
                    @foreach (['Nhà ở / căn hộ', 'Cửa hàng / văn phòng', 'Nhà xưởng / kho bãi'] as $index => $type)
                        <label class="flex cursor-pointer items-center gap-2.5 rounded-lg border border-slate-200 p-3 text-sm has-checked:border-brand-500 has-checked:bg-brand-50">
                            <input type="radio" name="type" class="accent-brand-600" @checked($index === 0)>{{ $type }}
                        </label>
                    @endforeach
                </div>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="label" for="cameras">Số camera dự kiến</label>
                        <input id="cameras" type="number" class="input" placeholder="VD: 4">
                    </div>
                    <div>
                        <label class="label" for="budget">Ngân sách khách dự kiến</label>
                        <select id="budget" class="input"><option>Chưa rõ</option><option>&lt; 10 triệu</option><option>10 – 30 triệu</option><option>&gt; 30 triệu</option></select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="label" for="need">Mô tả yêu cầu</label>
                        <textarea id="need" rows="3" class="input" placeholder="VD: 4 camera ngoài trời, xem qua điện thoại, lưu 15 ngày…"></textarea>
                    </div>
                    <div>
                        <label class="label" for="time">Khung giờ khách tiện liên hệ</label>
                        <input id="time" class="input" placeholder="VD: sau 17h các ngày trong tuần">
                    </div>
                    <div>
                        <label class="label" for="source">Nguồn khách</label>
                        <select id="source" class="input"><option>Khách giới thiệu</option><option>Facebook / Zalo</option><option>Google</option><option>Khách cũ</option></select>
                    </div>
                </div>
            </section>
        </div>

        <aside class="space-y-4">
            <div class="card p-5">
                <h3 class="text-sm font-semibold text-slate-900">Sau khi gửi</h3>
                <ol class="mt-3 space-y-3 text-sm text-slate-600">
                    <li class="flex gap-2.5"><span class="grid size-5 shrink-0 place-items-center rounded-full bg-brand-100 text-[11px] font-semibold text-brand-700">1</span>Kế toán nhận thông báo, gọi xác minh khách.</li>
                    <li class="flex gap-2.5"><span class="grid size-5 shrink-0 place-items-center rounded-full bg-brand-100 text-[11px] font-semibold text-brand-700">2</span>Gán Kỹ thuật – SLA có mặt 30 phút.</li>
                    <li class="flex gap-2.5"><span class="grid size-5 shrink-0 place-items-center rounded-full bg-brand-100 text-[11px] font-semibold text-brand-700">3</span>Bạn theo dõi tiến độ tại “Tổng quan của tôi”.</li>
                </ol>
                <div class="mt-4 rounded-lg bg-amber-50 p-3 text-xs text-amber-800">SLA tạo lead & đẩy Kế toán: <b>&lt; 5 phút</b>. Đồng hồ đang chạy: <b>01:12</b></div>
            </div>
            <button type="submit" class="btn-primary w-full py-2.5"><x-icon name="send" class="size-4" />Gửi cho Kế toán</button>
            <button type="button" class="btn-ghost w-full">Lưu nháp</button>
        </aside>
    </form>

    <dialog id="lead-created" class="m-auto w-full max-w-sm rounded-2xl p-6 text-center shadow-2xl backdrop:bg-slate-900/40">
        <span class="mx-auto grid size-12 place-items-center rounded-full bg-emerald-100 text-emerald-600"><x-icon name="check" class="size-6" /></span>
        <h2 class="mt-4 text-lg font-semibold">Đã tạo lead DH-2411-029</h2>
        <p class="mt-1 text-sm text-slate-500">Đã đẩy cho Kế toán Thu Trang. Trạng thái: Chờ xác nhận.</p>
        <div class="mt-6 flex gap-2">
            <button data-close class="btn-ghost flex-1">Tạo lead khác</button>
            <a href="{{ route('sale.home') }}" class="btn-primary flex-1">Về tổng quan</a>
        </div>
    </dialog>
</x-layouts.app>
