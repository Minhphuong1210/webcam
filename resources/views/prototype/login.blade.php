<!DOCTYPE html>
<html lang="vi" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập · CamPro</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="grid h-full font-sans text-slate-800 antialiased lg:grid-cols-[1.1fr_1fr]">
    <section class="relative hidden overflow-hidden bg-ink-900 p-12 text-white lg:flex lg:flex-col">
        <div class="flex items-center gap-2.5">
            <span class="grid size-10 place-items-center rounded-lg bg-brand-500"><x-icon name="camera" /></span>
            <span class="text-lg font-semibold">CamPro</span>
        </div>

        <div class="my-auto max-w-lg">
            <p class="text-sm font-medium text-brand-200">Phần mềm quản lý lắp đặt camera</p>
            <h1 class="mt-3 text-4xl leading-tight font-semibold tracking-tight">Từ lead đến lợi nhuận — trên một luồng duy nhất.</h1>
            <p class="mt-4 text-slate-400">Sale tạo lead, Kế toán điều phối & báo giá, Kỹ thuật khảo sát – thi công trên App, Quản lý theo dõi thu tiền, công nợ và chia lợi nhuận từng đơn.</p>

            <ol class="mt-10 grid grid-cols-3 gap-3 text-sm">
                @foreach (['Sale nhập khách hàng', 'Kế toán giao khảo sát', 'KT khảo sát & báo chi phí', 'Báo giá & hẹn lịch', 'KT lắp đặt', 'Thu tiền & chia lợi nhuận'] as $index => $step)
                    <li class="rounded-lg border border-white/10 bg-white/5 p-3">
                        <span class="text-xs text-brand-200">Bước {{ $index + 1 }}</span>
                        <p class="mt-1 font-medium">{{ $step }}</p>
                    </li>
                @endforeach
            </ol>
        </div>

        <p class="text-xs text-slate-500">Bản thiết kế giao diện · dữ liệu mẫu</p>
        <div class="pointer-events-none absolute -right-24 -bottom-24 size-96 rounded-full bg-brand-500/20 blur-3xl"></div>
    </section>

    <section class="flex items-center justify-center bg-white p-6">
        <div class="w-full max-w-sm">
            <h2 class="text-2xl font-semibold tracking-tight text-slate-900">Đăng nhập</h2>
            <p class="mt-1 text-sm text-slate-500">Dùng tài khoản nội bộ do Admin cấp.</p>

            <form class="mt-8 space-y-4" onsubmit="return false">
                <div>
                    <label class="label" for="username">Mã nhân viên / SĐT</label>
                    <input id="username" class="input" placeholder="VD: KTO2 hoặc 0909…" value="">
                </div>
                <div>
                    <label class="label" for="password">Mật khẩu</label>
                    <input id="password" type="password" class="input" placeholder="••••••••">
                </div>
            </form>

            <p class="mt-8 mb-3 text-xs font-semibold tracking-wider text-slate-400 uppercase">Xem nhanh theo vai trò (demo)</p>
            <div class="grid grid-cols-2 gap-3">
                @php($descriptions = ['admin' => 'Theo dõi, báo cáo, tỷ lệ chia', 'sale' => 'Khách hàng, theo dõi yêu cầu', 'ketoan' => 'Điều phối, báo giá, thu tiền', 'kythuat' => 'App mobile hiện trường'])
                @php($icons = ['admin' => 'tower', 'sale' => 'user-plus', 'ketoan' => 'wallet', 'kythuat' => 'phone'])
                @foreach ($roles as $key => $role)
                    <a href="{{ route('role.switch', $key) }}" class="group rounded-xl border border-slate-200 p-3 transition hover:border-brand-500 hover:bg-brand-50">
                        <x-icon :name="$icons[$key]" class="size-5 text-brand-600" />
                        <p class="mt-2 text-sm font-semibold text-slate-900">{{ $role['label'] }}</p>
                        <p class="text-xs text-slate-500">{{ $descriptions[$key] }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
</body>
</html>
