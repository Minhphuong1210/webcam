@php
    use App\Support\DemoData;

    $customerList = collect($customers);
    $activeCount = $customerList->whereNotIn('latest_status', ['hoan_thanh'])->count();
@endphp

<x-layouts.app title="Khách hàng">
    <x-page-header title="Khách hàng" subtitle="Thông tin khách hàng, địa chỉ, số điện thoại, nhu cầu lắp đặt và tiến độ đơn gần nhất">
        <x-slot:actions>
            <button class="btn-ghost"><x-icon name="download" class="size-4" />Xuất Excel</button>
            <a href="{{ route('leads.create') }}" class="btn-primary"><x-icon name="user-plus" class="size-4" />Thêm khách hàng</a>
        </x-slot:actions>
    </x-page-header>

    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        <x-stat label="Tổng khách hàng" :value="(string) $customerList->count()" hint="Tháng 11/2026" icon="users" tone="brand" />
        <x-stat label="Đang có đơn xử lý" :value="(string) $activeCount" hint="Chưa hoàn thành" icon="clock" tone="amber" />
        <x-stat label="Khách quay lại" :value="(string) $customerList->where('orders', '>', 1)->count()" hint="Từ 2 đơn trở lên" icon="refresh" tone="emerald" />
        <x-stat label="Khách giới thiệu" :value="(string) $customerList->where('source', 'Khách giới thiệu')->count()" hint="Nguồn khách" icon="user-plus" />
    </div>

    <div class="card mt-6 overflow-hidden">
        <div class="flex flex-wrap items-center gap-2 border-b border-slate-100 p-3">
            <div class="relative min-w-56 flex-1">
                <x-icon name="search" class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-slate-400" />
                <input class="input pl-9" placeholder="Tên khách, số điện thoại, địa chỉ…">
            </div>
            <select class="input w-auto"><option>Mọi loại công trình</option><option>Nhà ở / căn hộ</option><option>Cửa hàng</option><option>Nhà xưởng</option><option>Trường học</option></select>
            <select class="input w-auto"><option>Mọi nguồn khách</option><option>Khách giới thiệu</option><option>Facebook</option><option>Gọi hotline</option><option>Khách cũ</option></select>
            <select class="input w-auto"><option>Mọi Sale</option><option>Mai Anh</option><option>Quang Huy</option></select>
        </div>
        <div class="overflow-x-auto">
            <table class="table-base min-w-[1080px]">
                <thead>
                    <tr>
                        <th>Khách hàng</th>
                        <th>Địa chỉ lắp đặt</th>
                        <th>Loại công trình</th>
                        <th>Nguồn</th>
                        <th>Sale phụ trách</th>
                        <th>Đơn gần nhất</th>
                        <th class="text-right">Số đơn</th>
                        <th class="text-right">Đã chi tiêu</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customerList as $customer)
                        <tr>
                            <td>
                                <div class="flex items-center gap-2.5">
                                    <x-avatar :initials="DemoData::initials($customer['name'])" />
                                    <div>
                                        <p class="font-medium whitespace-nowrap text-slate-900">{{ $customer['name'] }}</p>
                                        <a href="tel:{{ str_replace(' ', '', $customer['phone']) }}" class="text-xs whitespace-nowrap text-slate-500 hover:text-brand-700">{{ $customer['phone'] }}</a>
                                    </div>
                                </div>
                            </td>
                            <td class="max-w-60"><p class="truncate text-slate-600" title="{{ $customer['address'] }}">{{ $customer['address'] }}</p></td>
                            <td class="whitespace-nowrap">{{ $customer['type'] }}</td>
                            <td class="text-xs whitespace-nowrap text-slate-500">{{ $customer['source'] }}</td>
                            <td class="whitespace-nowrap">{{ $customer['sale'] }}</td>
                            <td>
                                <a href="{{ route('orders.show', $customer['latest_order']) }}" class="font-mono text-xs whitespace-nowrap text-brand-700 hover:underline">{{ $customer['latest_order'] }}</a>
                                <div class="mt-1"><x-status :status="$customer['latest_status']" /></div>
                            </td>
                            <td class="text-right tabular-nums">{{ $customer['orders'] }}</td>
                            <td class="text-right font-medium whitespace-nowrap tabular-nums">{{ $customer['total_spent'] ? DemoData::money($customer['total_spent']) : '—' }}</td>
                            <td class="text-right">
                                <a href="{{ route('orders.show', $customer['latest_order']) }}" class="inline-flex rounded-md p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-700" title="Xem chi tiết"><x-icon name="chevron-right" class="size-4" /></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex items-center justify-between px-4 py-3 text-sm text-slate-500">
            <span>Hiển thị {{ $customerList->count() }} khách hàng</span>
            <div class="flex gap-1">
                <button class="btn-ghost px-2.5 py-1"><x-icon name="chevron-left" class="size-4" /></button>
                <button class="btn-ghost px-2.5 py-1"><x-icon name="chevron-right" class="size-4" /></button>
            </div>
        </div>
    </div>
</x-layouts.app>
