@php
    $role = session('role', 'admin');
    $roles = \App\Support\DemoData::roles();

    $navigation = [
        'admin' => [
            'Giám sát' => [
                ['route' => 'dashboard', 'label' => 'Control Tower', 'icon' => 'tower'],
                ['route' => 'customers.index', 'label' => 'Khách hàng', 'icon' => 'users'],
                ['route' => 'orders.index', 'label' => 'Đơn hàng', 'icon' => 'list', 'badge' => '10'],
                ['route' => 'reports', 'label' => 'Báo cáo thống kê', 'icon' => 'chart'],
            ],
            'Tài chính' => [
                ['route' => 'finance', 'label' => 'Thu tiền & công nợ', 'icon' => 'wallet'],
                ['route' => 'allocations', 'label' => 'Tỷ lệ chia lợi nhuận', 'icon' => 'sliders'],
            ],
            'Vận hành' => [
                ['route' => 'inventory', 'label' => 'Kho 2 tầng', 'icon' => 'box'],
                ['route' => 'warranty', 'label' => 'Bảo hành & Serial', 'icon' => 'shield'],
                ['route' => 'audit', 'label' => 'Audit Log', 'icon' => 'history'],
            ],
        ],
        'sale' => [
            'Bán hàng' => [
                ['route' => 'sale.home', 'label' => 'Tổng quan của tôi', 'icon' => 'home'],
                ['route' => 'customers.index', 'label' => 'Khách hàng', 'icon' => 'users'],
                ['route' => 'leads.create', 'label' => 'Nhập khách mới', 'icon' => 'user-plus'],
                ['route' => 'orders.index', 'label' => 'Theo dõi yêu cầu', 'icon' => 'list'],
                ['route' => 'warranty', 'label' => 'Phiếu bảo hành', 'icon' => 'shield'],
            ],
        ],
        'ketoan' => [
            'Điều phối' => [
                ['route' => 'dispatch', 'label' => 'Tiếp nhận & điều phối', 'icon' => 'route', 'badge' => '4'],
                ['route' => 'quotes.show', 'params' => ['code' => 'DH-2411-024'], 'label' => 'Báo giá', 'icon' => 'file', 'badge' => '1'],
                ['route' => 'schedule', 'label' => 'Lịch triển khai', 'icon' => 'calendar'],
                ['route' => 'orders.index', 'label' => 'Theo dõi đơn hàng', 'icon' => 'list'],
            ],
            'Tài chính' => [
                ['route' => 'finance', 'label' => 'Thu tiền & công nợ', 'icon' => 'wallet'],
                ['route' => 'allocations', 'label' => 'Chi phí & lợi nhuận', 'icon' => 'sliders'],
                ['route' => 'inventory', 'label' => 'Kho vật tư', 'icon' => 'box'],
                ['route' => 'warranty', 'label' => 'Bảo hành & Serial', 'icon' => 'shield'],
            ],
        ],
        'kythuat' => [
            'Kỹ thuật' => [
                ['route' => 'mobile', 'label' => 'App Kỹ thuật (Mobile)', 'icon' => 'phone'],
            ],
        ],
    ];

    $users = [
        'admin' => ['name' => 'Admin Thịnh', 'initials' => 'AT'],
        'sale' => ['name' => 'Mai Anh', 'initials' => 'MA'],
        'ketoan' => ['name' => 'Thu Trang', 'initials' => 'TT'],
        'kythuat' => ['name' => 'Lê Quốc Bảo', 'initials' => 'LB'],
    ];
@endphp
<!DOCTYPE html>
<html lang="vi" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'CamPro' }} · CamPro Quản lý lắp đặt</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full overflow-x-hidden font-sans text-slate-800 antialiased">
<input type="checkbox" id="nav-toggle" class="peer hidden">

{{-- Sidebar --}}
<aside class="fixed inset-y-0 left-0 z-40 flex w-64 -translate-x-full flex-col bg-ink-900 text-slate-300 transition peer-checked:translate-x-0 lg:translate-x-0">
    <a href="{{ route('login') }}" class="flex h-16 items-center gap-2.5 px-5">
        <span class="grid size-9 place-items-center rounded-lg bg-brand-500 text-white"><x-icon name="camera" class="size-5" /></span>
        <span>
            <span class="block text-sm font-semibold text-white">CamPro</span>
            <span class="block text-[11px] text-slate-400">Quản lý lắp đặt camera</span>
        </span>
    </a>

    <nav class="flex-1 space-y-6 overflow-y-auto px-3 py-4">
        @foreach ($navigation[$role] as $group => $items)
            <div>
                <p class="px-3 pb-2 text-[11px] font-semibold tracking-wider text-slate-500 uppercase">{{ $group }}</p>
                <ul class="space-y-0.5">
                    @foreach ($items as $item)
                        @php($isActive = request()->routeIs($item['route']))
                        <li>
                            <a href="{{ route($item['route'], $item['params'] ?? []) }}"
                               @class([
                                   'flex items-center gap-3 rounded-lg px-3 py-2 text-sm transition',
                                   'bg-white/10 text-white' => $isActive,
                                   'hover:bg-white/5 hover:text-white' => ! $isActive,
                               ])>
                                <x-icon :name="$item['icon']" @class(['size-[18px]', 'text-brand-200' => $isActive]) />
                                <span class="flex-1">{{ $item['label'] }}</span>
                                @isset($item['badge'])
                                    <span class="rounded-full bg-rose-500 px-1.5 text-[11px] font-semibold text-white">{{ $item['badge'] }}</span>
                                @endisset
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </nav>

    <div class="border-t border-white/10 p-3">
        <div class="flex items-center gap-3 rounded-lg px-2 py-2">
            <x-avatar :initials="$users[$role]['initials']" class="bg-white/10 text-white" />
            <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-medium text-white">{{ $users[$role]['name'] }}</p>
                <p class="text-xs text-slate-400">{{ $roles[$role]['label'] }}</p>
            </div>
            <a href="{{ route('login') }}" class="rounded-md p-1.5 hover:bg-white/10" title="Đăng xuất"><x-icon name="logout" class="size-4" /></a>
        </div>
    </div>
</aside>
<label for="nav-toggle" class="fixed inset-0 z-30 hidden bg-slate-900/40 peer-checked:block lg:hidden!"></label>

<div class="lg:pl-64">
    {{-- Topbar --}}
    <header class="sticky top-0 z-20 flex h-16 items-center gap-3 border-b border-slate-200 bg-white/90 px-4 backdrop-blur sm:px-6">
        <label for="nav-toggle" class="-ml-1 rounded-md p-2 text-slate-600 hover:bg-slate-100 lg:hidden"><x-icon name="list" /></label>

        <div class="relative hidden max-w-md flex-1 md:block">
            <x-icon name="search" class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-slate-400" />
            <input type="search" class="input pl-9" placeholder="Tìm mã đơn, tên khách, SĐT, serial thiết bị…">
        </div>
        <div class="flex-1 md:hidden"></div>

        <select class="input w-auto py-1.5 sm:hidden" onchange="window.location = this.value" aria-label="Chuyển vai trò">
            @foreach ($roles as $key => $definition)
                <option value="{{ route('role.switch', $key) }}" @selected($role === $key)>{{ $definition['label'] }}</option>
            @endforeach
        </select>
        <div class="hidden items-center gap-1 rounded-lg bg-slate-100 p-1 text-xs font-medium sm:flex">
            @foreach ($roles as $key => $definition)
                <a href="{{ route('role.switch', $key) }}"
                   @class([
                       'rounded-md px-2.5 py-1.5 transition',
                       'bg-white text-slate-900 shadow-xs' => $role === $key,
                       'text-slate-500 hover:text-slate-800' => $role !== $key,
                   ])>{{ \Illuminate\Support\Str::before($definition['label'], ' (') }}</a>
            @endforeach
        </div>

        <button type="button" data-open="notifications" class="relative rounded-lg p-2 text-slate-600 hover:bg-slate-100">
            <x-icon name="bell" />
            <span class="absolute top-1.5 right-1.5 size-2 rounded-full bg-rose-500 ring-2 ring-white"></span>
        </button>
    </header>

    <main class="mx-auto max-w-[1440px] px-4 py-6 sm:px-6 lg:px-8">
        {{ $slot }}
    </main>
</div>

{{-- Notifications drawer --}}
<dialog id="notifications" class="m-0 ml-auto h-full max-h-none w-full max-w-sm bg-white p-0 shadow-2xl backdrop:bg-slate-900/30">
    <div class="flex h-16 items-center justify-between border-b border-slate-200 px-5">
        <h2 class="font-semibold">Thông báo</h2>
        <button data-close class="rounded-md p-1.5 hover:bg-slate-100"><x-icon name="x" class="size-4" /></button>
    </div>
    <ul class="divide-y divide-slate-100">
        @foreach (\App\Support\DemoData::alerts() as $alert)
            <li class="flex gap-3 px-5 py-4">
                <span class="mt-0.5 grid size-8 shrink-0 place-items-center rounded-full bg-rose-50 text-rose-600"><x-icon name="alert" class="size-4" /></span>
                <div class="text-sm">
                    <p class="font-medium text-slate-900">{{ $alert['title'] }}</p>
                    <p class="mt-0.5 text-slate-500">{{ $alert['order'] }} · {{ $alert['time'] }}</p>
                </div>
            </li>
        @endforeach
        <li class="flex gap-3 px-5 py-4">
            <span class="mt-0.5 grid size-8 shrink-0 place-items-center rounded-full bg-amber-50 text-amber-600"><x-icon name="clock" class="size-4" /></span>
            <div class="text-sm">
                <p class="font-medium text-slate-900">Nhắc 1h: bắn đơn DH-2411-027 lên App</p>
                <p class="mt-0.5 text-slate-500">Lịch hẹn lại 15:00 · Khách bận</p>
            </div>
        </li>
    </ul>
</dialog>
</body>
</html>
