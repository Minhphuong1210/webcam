<?php

namespace App\Support;

/**
 * Static sample data used by the UI prototype until real models exist.
 */
class DemoData
{
    /**
     * Order pipeline steps, in business-flow order.
     *
     * @return array<string, array{label: string, step: int, color: string}>
     */
    public static function statuses(): array
    {
        return [
            'cho_xac_nhan' => ['label' => 'Chờ xác nhận', 'step' => 1, 'color' => 'amber'],
            'cho_khao_sat' => ['label' => 'Chờ khảo sát', 'step' => 2, 'color' => 'sky'],
            'cho_bao_gia' => ['label' => 'Chờ báo giá', 'step' => 3, 'color' => 'violet'],
            'dang_thi_cong' => ['label' => 'Đang thi công', 'step' => 4, 'color' => 'blue'],
            'nghiem_thu' => ['label' => 'Nghiệm thu & thu tiền', 'step' => 5, 'color' => 'teal'],
            'hoan_thanh' => ['label' => 'Hoàn thành', 'step' => 6, 'color' => 'emerald'],
            'khach_ban' => ['label' => 'Khách bận / Chờ gọi lại', 'step' => 1, 'color' => 'orange'],
            'khach_hoan' => ['label' => 'Khách hoãn khảo sát', 'step' => 2, 'color' => 'orange'],
            'che_dat' => ['label' => 'Chê đắt / Cần Admin', 'step' => 3, 'color' => 'rose'],
            'bao_hanh' => ['label' => 'Đang bảo hành', 'step' => 6, 'color' => 'fuchsia'],
        ];
    }

    /**
     * @return array<string, array{label: string, home: string}>
     */
    public static function roles(): array
    {
        return [
            'admin' => ['label' => 'Admin (Quản lý)', 'home' => 'dashboard'],
            'sale' => ['label' => 'Sale', 'home' => 'sale.home'],
            'ketoan' => ['label' => 'Kế toán', 'home' => 'dispatch'],
            'kythuat' => ['label' => 'Kỹ thuật', 'home' => 'mobile'],
        ];
    }

    /**
     * @return list<array{code: string, name: string, phone: string, initials: string, status: string, lat: float, lng: float, area: string, jobs_today: int, cash_holding: int}>
     */
    public static function technicians(): array
    {
        return [
            ['code' => 'KT01', 'name' => 'Nguyễn Văn Hùng', 'phone' => '0903 112 233', 'initials' => 'NH', 'status' => 'surveying', 'lat' => 38, 'lng' => 42, 'area' => 'Q. Bình Thạnh', 'jobs_today' => 3, 'cash_holding' => 4500000],
            ['code' => 'KT02', 'name' => 'Trần Minh Tuấn', 'phone' => '0912 445 667', 'initials' => 'TT', 'status' => 'moving', 'lat' => 62, 'lng' => 30, 'area' => 'Q. 7', 'jobs_today' => 2, 'cash_holding' => 0],
            ['code' => 'KT03', 'name' => 'Lê Quốc Bảo', 'phone' => '0938 778 899', 'initials' => 'LB', 'status' => 'installing', 'lat' => 25, 'lng' => 70, 'area' => 'TP. Thủ Đức', 'jobs_today' => 2, 'cash_holding' => 12000000],
            ['code' => 'KT04', 'name' => 'Phạm Đức Long', 'phone' => '0977 223 344', 'initials' => 'PL', 'status' => 'free', 'lat' => 55, 'lng' => 58, 'area' => 'Q. 1', 'jobs_today' => 1, 'cash_holding' => 0],
            ['code' => 'KT05', 'name' => 'Võ Thành Nam', 'phone' => '0909 556 677', 'initials' => 'VN', 'status' => 'offline', 'lat' => 78, 'lng' => 75, 'area' => 'Q. 9 (mất sóng)', 'jobs_today' => 1, 'cash_holding' => 2300000],
        ];
    }

    /**
     * @return array<string, array{label: string, color: string}>
     */
    public static function technicianStatuses(): array
    {
        return [
            'free' => ['label' => 'Rảnh', 'color' => 'emerald'],
            'moving' => ['label' => 'Đang đi đường', 'color' => 'amber'],
            'surveying' => ['label' => 'Đang khảo sát', 'color' => 'sky'],
            'installing' => ['label' => 'Đang thi công', 'color' => 'blue'],
            'offline' => ['label' => 'Offline', 'color' => 'slate'],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function orders(): array
    {
        return [
            ['code' => 'DH-2411-028', 'customer' => 'Anh Khoa – Cafe Mộc', 'phone' => '0908 123 456', 'address' => '45 Phan Xích Long, P.2, Q. Phú Nhuận', 'need' => '6 camera ngoài trời + đầu ghi 8 kênh', 'status' => 'cho_xac_nhan', 'sale' => 'Mai Anh', 'tech' => null, 'value' => null, 'sla' => ['label' => 'Đẩy KT: còn 3 phút', 'state' => 'warn'], 'created' => '10:42', 'priority' => false],
            ['code' => 'DH-2411-027', 'customer' => 'Chị Hạnh – Nhà phố', 'phone' => '0937 556 112', 'address' => '12/4 Lê Văn Sỹ, P.13, Q.3', 'need' => '4 camera trong nhà, xem qua điện thoại', 'status' => 'khach_ban', 'sale' => 'Quang Huy', 'tech' => null, 'value' => null, 'sla' => ['label' => 'Nhắc gọi lại 14:00', 'state' => 'info'], 'created' => '09:15', 'priority' => false],
            ['code' => 'DH-2411-026', 'customer' => 'Công ty TNHH Minh Phát', 'phone' => '028 3812 4455', 'address' => 'KCN Tân Bình, Lô C12', 'need' => '16 camera nhà xưởng + switch PoE', 'status' => 'cho_khao_sat', 'sale' => 'Mai Anh', 'tech' => 'Nguyễn Văn Hùng', 'value' => null, 'sla' => ['label' => 'Quá hạn 30′ +8 phút', 'state' => 'late'], 'created' => '08:50', 'priority' => true],
            ['code' => 'DH-2411-025', 'customer' => 'Anh Dũng – Shop thời trang', 'phone' => '0918 334 778', 'address' => '210 Nguyễn Trãi, Q.1', 'need' => '3 camera + màn hình quầy', 'status' => 'cho_khao_sat', 'sale' => 'Quang Huy', 'tech' => 'Trần Minh Tuấn', 'value' => null, 'sla' => ['label' => 'Có mặt: còn 12 phút', 'state' => 'ok'], 'created' => '09:40', 'priority' => false],
            ['code' => 'DH-2411-024', 'customer' => 'Trường MN Hoa Sen', 'phone' => '0283 991 220', 'address' => '88 Đường số 9, TP. Thủ Đức', 'need' => '10 camera lớp học, lưu 30 ngày', 'status' => 'cho_bao_gia', 'sale' => 'Mai Anh', 'tech' => 'Lê Quốc Bảo', 'value' => 28600000, 'sla' => ['label' => 'Báo giá: còn 4 phút', 'state' => 'warn'], 'created' => 'Hôm qua', 'priority' => false],
            ['code' => 'DH-2411-023', 'customer' => 'Chú Tư – Nhà vườn', 'phone' => '0965 112 990', 'address' => 'Ấp 3, Củ Chi', 'need' => '4 camera 4G năng lượng mặt trời', 'status' => 'che_dat', 'sale' => 'Quang Huy', 'tech' => 'Võ Thành Nam', 'value' => 19800000, 'sla' => ['label' => 'Chờ Admin duyệt 22′', 'state' => 'late'], 'created' => 'Hôm qua', 'priority' => false],
            ['code' => 'DH-2411-021', 'customer' => 'Nhà hàng Biển Xanh', 'phone' => '0909 887 665', 'address' => '5 Trần Não, TP. Thủ Đức', 'need' => '8 camera + chuông cửa', 'status' => 'dang_thi_cong', 'sale' => 'Mai Anh', 'tech' => 'Lê Quốc Bảo', 'value' => 23400000, 'sla' => ['label' => 'Hạn thi công 16:30', 'state' => 'ok'], 'created' => '09/11', 'priority' => false],
            ['code' => 'DH-2411-019', 'customer' => 'Chị Lan – Căn hộ Sunrise', 'phone' => '0903 445 001', 'address' => 'Sunrise City, Q.7', 'need' => '2 camera Wi-Fi', 'status' => 'nghiem_thu', 'sale' => 'Quang Huy', 'tech' => 'Trần Minh Tuấn', 'value' => 4200000, 'sla' => ['label' => 'Chờ thu tiền', 'state' => 'info'], 'created' => '08/11', 'priority' => false],
            ['code' => 'DH-2411-017', 'customer' => 'Kho Hàng Tân Phú', 'phone' => '0938 001 223', 'address' => '120 Lũy Bán Bích, Q. Tân Phú', 'need' => '12 camera + đầu ghi 16 kênh', 'status' => 'hoan_thanh', 'sale' => 'Mai Anh', 'tech' => 'Nguyễn Văn Hùng', 'value' => 36500000, 'sla' => ['label' => 'Đúng SLA', 'state' => 'ok'], 'created' => '06/11', 'priority' => false],
            ['code' => 'DH-2410-102', 'customer' => 'Anh Phong – Biệt thự', 'phone' => '0912 667 889', 'address' => '22 Nguyễn Văn Hưởng, Thảo Điền', 'need' => 'Camera cổng mất hình', 'status' => 'bao_hanh', 'sale' => 'Quang Huy', 'tech' => 'Phạm Đức Long', 'value' => 0, 'sla' => ['label' => 'Bảo hành – KT cũ', 'state' => 'info'], 'created' => '28/10', 'priority' => true],
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    public static function order(string $code): ?array
    {
        return collect(self::orders())->firstWhere('code', $code);
    }

    /**
     * @return list<array{type: string, title: string, detail: string, order: string, time: string, from: string}>
     */
    public static function alerts(): array
    {
        return [
            ['type' => 'discount', 'title' => 'Khách chê đắt – đề xuất giảm 8%', 'detail' => 'Báo giá 19.800.000đ → đề xuất 18.216.000đ. Khách so sánh với đơn vị khác.', 'order' => 'DH-2411-023', 'time' => '22 phút trước', 'from' => 'Kế toán Thu Trang'],
            ['type' => 'material', 'title' => 'Bớt vật tư – 15m dây cáp mạng', 'detail' => 'KT Lê Quốc Bảo báo bớt 15m cáp Cat6 (−225.000đ) do khách tự đi dây.', 'order' => 'DH-2411-021', 'time' => '9 phút trước', 'from' => 'KT Lê Quốc Bảo'],
            ['type' => 'gps', 'title' => 'Check-in sai vị trí (cách 380m)', 'detail' => 'KT Nguyễn Văn Hùng check-in ngoài bán kính 50m.', 'order' => 'DH-2411-026', 'time' => '3 phút trước', 'from' => 'Hệ thống'],
        ];
    }

    /**
     * @return list<array{code: string, name: string, unit: string, cost: int, price: int, hq: int, min: int}>
     */
    public static function materials(): array
    {
        return [
            ['code' => 'CAM-IP4-OUT', 'name' => 'Camera IP 4MP ngoài trời (có màu ban đêm)', 'unit' => 'cái', 'cost' => 950000, 'price' => 1450000, 'hq' => 42, 'min' => 20],
            ['code' => 'CAM-WIFI-2', 'name' => 'Camera Wi-Fi 2MP xoay 360°', 'unit' => 'cái', 'cost' => 420000, 'price' => 690000, 'hq' => 15, 'min' => 20],
            ['code' => 'NVR-8CH', 'name' => 'Đầu ghi NVR 8 kênh', 'unit' => 'cái', 'cost' => 1650000, 'price' => 2400000, 'hq' => 9, 'min' => 5],
            ['code' => 'HDD-2TB', 'name' => 'Ổ cứng chuyên dụng 2TB', 'unit' => 'cái', 'cost' => 1350000, 'price' => 1750000, 'hq' => 11, 'min' => 6],
            ['code' => 'SW-POE-8', 'name' => 'Switch PoE 8 cổng', 'unit' => 'cái', 'cost' => 780000, 'price' => 1150000, 'hq' => 4, 'min' => 5],
            ['code' => 'CAB-CAT6', 'name' => 'Cáp mạng Cat6', 'unit' => 'mét', 'cost' => 9000, 'price' => 15000, 'hq' => 1850, 'min' => 500],
            ['code' => 'ACC-BOX', 'name' => 'Hộp kỹ thuật + nguồn', 'unit' => 'bộ', 'cost' => 65000, 'price' => 120000, 'hq' => 140, 'min' => 50],
        ];
    }

    /**
     * Per-technician mobile stock, keyed by technician code then material code.
     *
     * @return array<string, array<string, int>>
     */
    public static function mobileStock(): array
    {
        return [
            'KT01' => ['CAM-IP4-OUT' => 8, 'CAM-WIFI-2' => 2, 'NVR-8CH' => 1, 'HDD-2TB' => 1, 'SW-POE-8' => 1, 'CAB-CAT6' => 210, 'ACC-BOX' => 10],
            'KT02' => ['CAM-IP4-OUT' => 4, 'CAM-WIFI-2' => 4, 'NVR-8CH' => 1, 'HDD-2TB' => 1, 'SW-POE-8' => 0, 'CAB-CAT6' => 150, 'ACC-BOX' => 6],
            'KT03' => ['CAM-IP4-OUT' => 6, 'CAM-WIFI-2' => 0, 'NVR-8CH' => 2, 'HDD-2TB' => 2, 'SW-POE-8' => 1, 'CAB-CAT6' => 320, 'ACC-BOX' => 12],
            'KT04' => ['CAM-IP4-OUT' => 2, 'CAM-WIFI-2' => 3, 'NVR-8CH' => 0, 'HDD-2TB' => 0, 'SW-POE-8' => 1, 'CAB-CAT6' => 80, 'ACC-BOX' => 4],
            'KT05' => ['CAM-IP4-OUT' => 5, 'CAM-WIFI-2' => 1, 'NVR-8CH' => 1, 'HDD-2TB' => 1, 'SW-POE-8' => 2, 'CAB-CAT6' => 260, 'ACC-BOX' => 8],
        ];
    }

    /**
     * Line items for the sample quote (DH-2411-024).
     *
     * @return list<array{code: string, name: string, qty: int, draft_price: int, std_price: int, cost: int}>
     */
    public static function quoteLines(): array
    {
        return [
            ['code' => 'CAM-IP4-OUT', 'name' => 'Camera IP 4MP (lắp trong lớp, chân đế trần)', 'qty' => 10, 'draft_price' => 1400000, 'std_price' => 1450000, 'cost' => 950000],
            ['code' => 'NVR-8CH', 'name' => 'Đầu ghi NVR 8 kênh', 'qty' => 2, 'draft_price' => 2400000, 'std_price' => 2400000, 'cost' => 1650000],
            ['code' => 'HDD-2TB', 'name' => 'Ổ cứng 2TB (lưu 30 ngày)', 'qty' => 2, 'draft_price' => 1750000, 'std_price' => 1750000, 'cost' => 1350000],
            ['code' => 'CAB-CAT6', 'name' => 'Cáp mạng Cat6', 'qty' => 180, 'draft_price' => 15000, 'std_price' => 15000, 'cost' => 9000],
            ['code' => 'ACC-BOX', 'name' => 'Hộp kỹ thuật + nguồn', 'qty' => 10, 'draft_price' => 100000, 'std_price' => 120000, 'cost' => 65000],
            ['code' => 'LABOR', 'name' => 'Công lắp đặt & cấu hình', 'qty' => 1, 'draft_price' => 3000000, 'std_price' => 3000000, 'cost' => 0],
        ];
    }

    /**
     * @return list<array{time: string, user: string, action: string, target: string, before: string, after: string, diff: string, reason: string, kind: string}>
     */
    public static function auditLogs(): array
    {
        return [
            ['time' => '11/11 10:58:12', 'user' => 'AD01 · Admin Thịnh', 'action' => 'Cập nhật tỷ lệ chia lợi nhuận', 'target' => 'Cấu hình chung', 'before' => 'KT 45% · Cty 35%', 'after' => 'KT 50% · Cty 30%', 'diff' => '±5%', 'reason' => 'Áp dụng chính sách tháng 11', 'kind' => 'allocation'],
            ['time' => '11/11 10:41:05', 'user' => 'KT03 · Lê Quốc Bảo', 'action' => 'Đề xuất bớt vật tư', 'target' => 'DH-2411-021', 'before' => '180m Cat6', 'after' => '165m Cat6', 'diff' => '−225.000đ', 'reason' => 'Khách tự đi dây tầng 2', 'kind' => 'material'],
            ['time' => '11/11 10:20:47', 'user' => 'KTO2 · Thu Trang', 'action' => 'Sửa đơn giá báo giá', 'target' => 'DH-2411-024', 'before' => '1.400.000đ', 'after' => '1.450.000đ', 'diff' => '+500.000đ', 'reason' => 'Áp bảng giá chuẩn công ty', 'kind' => 'quote'],
            ['time' => '11/11 09:58:30', 'user' => 'KT03 · Lê Quốc Bảo', 'action' => 'Tạo báo giá nháp (offline → sync)', 'target' => 'DH-2411-024', 'before' => '—', 'after' => '27.450.000đ', 'diff' => '—', 'reason' => 'Khảo sát thực địa', 'kind' => 'quote'],
            ['time' => '10/11 17:12:09', 'user' => 'AD01 · Admin Thịnh', 'action' => 'Duyệt giảm giá ngoại lệ', 'target' => 'DH-2411-015', 'before' => '15.600.000đ', 'after' => '14.800.000đ', 'diff' => '−800.000đ', 'reason' => 'Khách quen, giới thiệu 2 đơn', 'kind' => 'discount'],
            ['time' => '10/11 16:03:44', 'user' => 'KTO2 · Thu Trang', 'action' => 'Ghi nhận chi phí khác', 'target' => 'DH-2411-012', 'before' => '5.100.000đ', 'after' => '5.600.000đ', 'diff' => '+500.000đ', 'reason' => 'Thuê thang nâng lắp camera cao', 'kind' => 'cost'],
        ];
    }

    /**
     * Default profit split (percent of profit) per role; must total 100.
     *
     * @return array<string, array{label: string, percent: int}>
     */
    public static function profitSplit(): array
    {
        return [
            'tech' => ['label' => 'Kỹ thuật', 'percent' => 50],
            'sale' => ['label' => 'Sale', 'percent' => 10],
            'accountant' => ['label' => 'Kế toán', 'percent' => 10],
            'company' => ['label' => 'Công ty', 'percent' => 30],
        ];
    }

    /**
     * Completed & fully-paid orders with their actual costs, used to compute and split profit.
     *
     * @return list<array{order: string, customer: string, revenue: int, material_cost: int, extra_cost: int, other_cost: int, sale: string, tech: string, accountant: string, note: string}>
     */
    public static function profitOrders(): array
    {
        return [
            ['order' => 'DH-2411-017', 'customer' => 'Kho Hàng Tân Phú', 'revenue' => 36500000, 'material_cost' => 21800000, 'extra_cost' => 600000, 'other_cost' => 400000, 'sale' => 'Mai Anh', 'tech' => 'Nguyễn Văn Hùng', 'accountant' => 'Thu Trang', 'note' => 'Phát sinh 40m cáp + nẹp'],
            ['order' => 'DH-2411-016', 'customer' => 'Văn phòng Luật Tâm An', 'revenue' => 12400000, 'material_cost' => 7300000, 'extra_cost' => 0, 'other_cost' => 300000, 'sale' => 'Quang Huy', 'tech' => 'Phạm Đức Long', 'accountant' => 'Thu Trang', 'note' => 'Chi phí đi lại'],
            ['order' => 'DH-2411-015', 'customer' => 'Tiệm vàng Kim Phát', 'revenue' => 14800000, 'material_cost' => 8900000, 'extra_cost' => 200000, 'other_cost' => 300000, 'sale' => 'Mai Anh', 'tech' => 'Trần Minh Tuấn', 'accountant' => 'Thu Trang', 'note' => 'Phát sinh hộp kỹ thuật'],
            ['order' => 'DH-2411-012', 'customer' => 'Homestay Đà Lạt Xanh', 'revenue' => 9600000, 'material_cost' => 5100000, 'extra_cost' => 0, 'other_cost' => 500000, 'sale' => 'Quang Huy', 'tech' => 'Lê Quốc Bảo', 'accountant' => 'Thu Trang', 'note' => 'Thuê thang nâng'],
        ];
    }

    /**
     * Customers managed by Sale, with their latest order.
     *
     * @return list<array{name: string, phone: string, address: string, type: string, source: string, sale: string, orders: int, latest_order: string, latest_status: string, total_spent: int}>
     */
    public static function customers(): array
    {
        $types = ['DH-2411-026' => 'Nhà xưởng', 'DH-2411-024' => 'Trường học', 'DH-2411-017' => 'Nhà xưởng', 'DH-2411-021' => 'Cửa hàng', 'DH-2411-025' => 'Cửa hàng'];
        $sources = ['Khách giới thiệu', 'Facebook', 'Gọi hotline', 'Khách cũ'];
        $history = ['DH-2410-102' => [2, 18500000], 'DH-2411-017' => [2, 52900000]];

        return collect(self::orders())->values()->map(fn (array $order, int $index): array => [
            'name' => $order['customer'],
            'phone' => $order['phone'],
            'address' => $order['address'],
            'type' => $types[$order['code']] ?? 'Nhà ở / căn hộ',
            'source' => $sources[$index % count($sources)],
            'sale' => $order['sale'],
            'orders' => $history[$order['code']][0] ?? 1,
            'latest_order' => $order['code'],
            'latest_status' => $order['status'],
            'total_spent' => $history[$order['code']][1] ?? (in_array($order['status'], ['hoan_thanh', 'nghiem_thu'], true) ? (int) $order['value'] : 0),
        ])->all();
    }

    /**
     * Survey/installation appointments for the deployment calendar (week 09–15/11).
     *
     * @return list<array{day: int, time: string, tech: string, order: string, customer: string, type: string, state: string}>
     */
    public static function schedule(): array
    {
        return [
            ['day' => 0, 'time' => '08:30', 'tech' => 'KT01', 'order' => 'DH-2411-017', 'customer' => 'Kho Hàng Tân Phú', 'type' => 'install', 'state' => 'done'],
            ['day' => 0, 'time' => '14:00', 'tech' => 'KT03', 'order' => 'DH-2411-021', 'customer' => 'Nhà hàng Biển Xanh', 'type' => 'survey', 'state' => 'done'],
            ['day' => 1, 'time' => '09:00', 'tech' => 'KT02', 'order' => 'DH-2411-019', 'customer' => 'Chị Lan – Căn hộ Sunrise', 'type' => 'install', 'state' => 'done'],
            ['day' => 1, 'time' => '15:30', 'tech' => 'KT04', 'order' => 'DH-2410-102', 'customer' => 'Anh Phong – Biệt thự', 'type' => 'survey', 'state' => 'done'],
            ['day' => 2, 'time' => '08:00', 'tech' => 'KT03', 'order' => 'DH-2411-021', 'customer' => 'Nhà hàng Biển Xanh', 'type' => 'install', 'state' => 'in_progress'],
            ['day' => 2, 'time' => '09:20', 'tech' => 'KT03', 'order' => 'DH-2411-024', 'customer' => 'Trường MN Hoa Sen', 'type' => 'survey', 'state' => 'done'],
            ['day' => 2, 'time' => '09:30', 'tech' => 'KT01', 'order' => 'DH-2411-026', 'customer' => 'Công ty TNHH Minh Phát', 'type' => 'survey', 'state' => 'late'],
            ['day' => 2, 'time' => '10:00', 'tech' => 'KT02', 'order' => 'DH-2411-025', 'customer' => 'Anh Dũng – Shop thời trang', 'type' => 'survey', 'state' => 'planned'],
            ['day' => 2, 'time' => '15:00', 'tech' => 'KT04', 'order' => 'DH-2411-027', 'customer' => 'Chị Hạnh – Nhà phố', 'type' => 'survey', 'state' => 'planned'],
            ['day' => 3, 'time' => '08:30', 'tech' => 'KT03', 'order' => 'DH-2411-024', 'customer' => 'Trường MN Hoa Sen', 'type' => 'install', 'state' => 'planned'],
            ['day' => 3, 'time' => '13:30', 'tech' => 'KT05', 'order' => 'DH-2411-023', 'customer' => 'Chú Tư – Nhà vườn', 'type' => 'install', 'state' => 'pending'],
            ['day' => 4, 'time' => '08:00', 'tech' => 'KT01', 'order' => 'DH-2411-026', 'customer' => 'Công ty TNHH Minh Phát', 'type' => 'install', 'state' => 'pending'],
            ['day' => 5, 'time' => '09:00', 'tech' => 'KT02', 'order' => 'DH-2411-025', 'customer' => 'Anh Dũng – Shop thời trang', 'type' => 'install', 'state' => 'pending'],
        ];
    }

    /**
     * @return list<array{order: string, customer: string, total: int, deposit: int, paid: int, method: string, due: string}>
     */
    public static function receivables(): array
    {
        return [
            ['order' => 'DH-2411-021', 'customer' => 'Nhà hàng Biển Xanh', 'total' => 23400000, 'deposit' => 7000000, 'paid' => 7000000, 'method' => 'Chuyển khoản', 'due' => '12/11'],
            ['order' => 'DH-2411-019', 'customer' => 'Chị Lan – Căn hộ Sunrise', 'total' => 4200000, 'deposit' => 0, 'paid' => 0, 'method' => '—', 'due' => 'Hôm nay'],
            ['order' => 'DH-2411-014', 'customer' => 'Spa Ngọc Lan', 'total' => 11800000, 'deposit' => 3000000, 'paid' => 8000000, 'method' => 'Tiền mặt (KT thu)', 'due' => 'Quá hạn 3 ngày'],
            ['order' => 'DH-2411-017', 'customer' => 'Kho Hàng Tân Phú', 'total' => 36500000, 'deposit' => 10000000, 'paid' => 36500000, 'method' => 'Chuyển khoản', 'due' => 'Đã thu đủ'],
        ];
    }

    /**
     * @return list<array{tech: string, order: string, amount: int, collected_at: string, status: string}>
     */
    public static function cashCollections(): array
    {
        return [
            ['tech' => 'Lê Quốc Bảo', 'order' => 'DH-2411-018', 'amount' => 12000000, 'collected_at' => '10/11 17:40', 'status' => 'holding'],
            ['tech' => 'Nguyễn Văn Hùng', 'order' => 'DH-2411-014', 'amount' => 4500000, 'collected_at' => '10/11 11:05', 'status' => 'holding'],
            ['tech' => 'Võ Thành Nam', 'order' => 'DH-2411-013', 'amount' => 2300000, 'collected_at' => '09/11 15:20', 'status' => 'overdue'],
            ['tech' => 'Trần Minh Tuấn', 'order' => 'DH-2411-015', 'amount' => 14800000, 'collected_at' => '09/11 10:10', 'status' => 'handed'],
        ];
    }

    /**
     * Revenue/cost/profit per week for the report chart (in millions VND).
     *
     * @return list<array{label: string, revenue: float, cost: float}>
     */
    public static function weeklyFinance(): array
    {
        return [
            ['label' => 'T10 · W1', 'revenue' => 82, 'cost' => 51],
            ['label' => 'T10 · W2', 'revenue' => 96, 'cost' => 58],
            ['label' => 'T10 · W3', 'revenue' => 74, 'cost' => 47],
            ['label' => 'T10 · W4', 'revenue' => 118, 'cost' => 69],
            ['label' => 'T11 · W1', 'revenue' => 104, 'cost' => 62],
            ['label' => 'T11 · W2', 'revenue' => 61, 'cost' => 36],
        ];
    }

    public static function initials(string $name): string
    {
        $words = explode(' ', trim($name));

        return mb_strtoupper(mb_substr($words[0], 0, 1).mb_substr(end($words), 0, 1));
    }

    public static function money(?int $amount): string
    {
        if ($amount === null) {
            return '—';
        }

        return number_format($amount, 0, ',', '.').'đ';
    }
}
