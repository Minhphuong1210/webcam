<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PrototypePagesTest extends TestCase
{
    /**
     * @return array<string, array{string, string}>
     */
    public static function pages(): array
    {
        return [
            'login' => ['/', 'Đăng nhập'],
            'control tower' => ['/control-tower', 'Visual Pipeline'],
            'orders' => ['/don-hang', 'DH-2411-028'],
            'orders filtered' => ['/don-hang?status=che_dat', 'Chú Tư'],
            'order detail' => ['/don-hang/DH-2411-024', 'Trường MN Hoa Sen'],
            'sale home' => ['/sale', 'Phần Sale được chia (10%)'],
            'create lead' => ['/sale/tao-lead', 'Gửi cho Kế toán'],
            'dispatch' => ['/dieu-phoi', 'Chọn Kỹ thuật'],
            'quote' => ['/bao-gia/DH-2411-024', 'Thẩm định báo giá'],
            'finance' => ['/tai-chinh', 'Đối soát tiền Kỹ thuật thu hộ'],
            'profit' => ['/chi-phi-loi-nhuan', 'Tỷ lệ chia lợi nhuận'],
            'customers' => ['/khach-hang', 'Chị Hạnh – Nhà phố'],
            'schedule' => ['/lich-trien-khai', 'Hẹn lịch lắp đặt'],
            'inventory' => ['/kho', 'Kho vật tư 2 tầng'],
            'warranty' => ['/bao-hanh', 'HK4M-2611-7301'],
            'audit' => ['/audit-log', 'Audit Log Inspector'],
            'reports' => ['/bao-cao', 'Hiệu quả theo nhân viên'],
            'mobile' => ['/app-ky-thuat', 'Check-in GPS'],
        ];
    }

    #[DataProvider('pages')]
    public function test_prototype_page_renders(string $uri, string $expectedText): void
    {
        foreach (['admin', 'sale', 'ketoan', 'kythuat'] as $role) {
            $this->withSession(['role' => $role])
                ->get($uri)
                ->assertOk()
                ->assertSee($expectedText);
        }
    }

    public function test_profit_page_applies_revenue_minus_cost_and_default_split(): void
    {
        $this->get(route('allocations'))
            ->assertOk()
            ->assertSee('Lợi nhuận = Doanh thu − Tổng chi phí')
            ->assertSee('13.700.000đ')
            ->assertSee('27.900.000đ')
            ->assertSee('13.950.000đ')
            ->assertSee('8.370.000đ');
    }

    public function test_switching_role_redirects_to_role_home(): void
    {
        $this->get('/vai-tro/ketoan')
            ->assertRedirect(route('dispatch'))
            ->assertSessionHas('role', 'ketoan');
    }

    public function test_unknown_role_and_order_return_not_found(): void
    {
        $this->get('/vai-tro/khach')->assertNotFound();
        $this->get('/don-hang/DH-0000-000')->assertNotFound();
    }
}
