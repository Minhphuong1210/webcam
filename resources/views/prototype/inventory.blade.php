@php
    use App\Support\DemoData;
@endphp

<x-layouts.app title="Kho 2 tầng">
    <x-page-header title="Kho vật tư 2 tầng" subtitle="Kho Tổng công ty + Kho di động của từng Kỹ thuật · tự trừ khi xuất lắp cho khách">
        <x-slot:actions>
            <button class="btn-ghost"><x-icon name="refresh" class="size-4" />Đối soát tồn kho</button>
            <button class="btn-primary"><x-icon name="send" class="size-4" />Cấp vật tư cho KT</button>
        </x-slot:actions>
    </x-page-header>

    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        <x-stat label="Giá trị kho tổng" value="128,4tr" icon="box" tone="brand" />
        <x-stat label="Giá trị kho di động" value="46,9tr" hint="5 Kỹ thuật" icon="users" />
        <x-stat label="Dưới định mức" value="2 mã" hint="Camera Wi-Fi, Switch PoE" icon="alert" tone="amber" />
        <x-stat label="Lệch đối soát" value="1 đơn" hint="DH-2411-021 · 15m cáp" icon="refresh" tone="rose" />
    </div>

    <div class="card mt-6 overflow-hidden">
        <x-card-header title="Tồn kho theo vật tư" subtitle="Kho tổng & phân bổ ở từng kho di động" />
        <div class="overflow-x-auto">
            <table class="table-base min-w-[1000px]">
                <thead>
                    <tr>
                        <th>Vật tư</th>
                        <th class="text-right">Giá vốn</th>
                        <th class="text-right">Giá bán chuẩn</th>
                        <th class="text-right">Kho tổng</th>
                        @foreach ($technicians as $technician)
                            <th class="text-center" title="{{ $technician['name'] }}">{{ $technician['code'] }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($materials as $material)
                        @php($isLow = $material['hq'] < $material['min'])
                        <tr>
                            <td><p class="font-medium text-slate-900">{{ $material['name'] }}</p><p class="font-mono text-xs text-slate-400">{{ $material['code'] }} · {{ $material['unit'] }}</p></td>
                            <td class="text-right tabular-nums">{{ DemoData::money($material['cost']) }}</td>
                            <td class="text-right tabular-nums">{{ DemoData::money($material['price']) }}</td>
                            <td class="text-right">
                                <span @class(['font-semibold tabular-nums', 'text-amber-700' => $isLow])>{{ number_format($material['hq'], 0, ',', '.') }}</span>
                                @if ($isLow)
                                    <p class="text-[11px] text-amber-700">ĐM {{ $material['min'] }}</p>
                                @endif
                            </td>
                            @foreach ($technicians as $technician)
                                @php($quantity = $mobileStock[$technician['code']][$material['code']] ?? 0)
                                <td class="text-center tabular-nums {{ $quantity === 0 ? 'text-slate-300' : '' }}">{{ $quantity }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mt-6 p-5">
        <h2 class="text-sm font-semibold text-slate-900">Đối soát sau hoàn thành đơn · DH-2411-021</h2>
        <div class="mt-4 grid gap-4 sm:grid-cols-3">
            <div class="rounded-lg bg-slate-50 p-3 text-sm"><p class="text-xs text-slate-500">Xuất kho lý thuyết (theo báo giá)</p><p class="mt-1 font-semibold">180m Cat6 · 8 camera · 1 NVR</p></div>
            <div class="rounded-lg bg-slate-50 p-3 text-sm"><p class="text-xs text-slate-500">Thực tế KT báo dùng</p><p class="mt-1 font-semibold">165m Cat6 · 8 camera · 1 NVR</p></div>
            <div class="rounded-lg bg-rose-50 p-3 text-sm text-rose-800"><p class="text-xs">Chênh lệch</p><p class="mt-1 font-semibold">−15m Cat6 · chờ Admin xác nhận bớt</p></div>
        </div>
    </div>
</x-layouts.app>
