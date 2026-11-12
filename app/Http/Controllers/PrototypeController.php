<?php

namespace App\Http\Controllers;

use App\Support\DemoData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Serves the clickable UI prototype screens with sample data.
 */
class PrototypeController extends Controller
{
    public function login(): View
    {
        return view('prototype.login', ['roles' => DemoData::roles()]);
    }

    public function switchRole(Request $request, string $role): RedirectResponse
    {
        $roles = DemoData::roles();

        abort_unless(isset($roles[$role]), 404);

        $request->session()->put('role', $role);

        return redirect()->route($roles[$role]['home']);
    }

    public function dashboard(): View
    {
        return view('prototype.dashboard', [
            'orders' => DemoData::orders(),
            'statuses' => DemoData::statuses(),
            'alerts' => DemoData::alerts(),
            'technicians' => DemoData::technicians(),
            'technicianStatuses' => DemoData::technicianStatuses(),
        ]);
    }

    public function orders(Request $request): View
    {
        $orders = collect(DemoData::orders());
        $status = $request->query('status');

        if ($status) {
            $orders = $orders->where('status', $status);
        }

        return view('prototype.orders.index', [
            'orders' => $orders->values()->all(),
            'statuses' => DemoData::statuses(),
            'activeStatus' => $status,
            'counts' => collect(DemoData::orders())->countBy('status')->all(),
        ]);
    }

    public function order(string $code): View
    {
        $order = DemoData::order($code);

        abort_if($order === null, 404);

        return view('prototype.orders.show', [
            'order' => $order,
            'profitSplit' => DemoData::profitSplit(),
            'statuses' => DemoData::statuses(),
            'lines' => DemoData::quoteLines(),
            'auditLogs' => collect(DemoData::auditLogs())->take(4)->all(),
        ]);
    }

    public function saleHome(): View
    {
        $myOrders = collect(DemoData::orders())->where('sale', 'Mai Anh')->values()->all();

        return view('prototype.sale.home', [
            'orders' => $myOrders,
            'statuses' => DemoData::statuses(),
        ]);
    }

    public function createLead(): View
    {
        return view('prototype.sale.create', ['sales' => ['Mai Anh', 'Quang Huy']]);
    }

    public function dispatch(): View
    {
        return view('prototype.dispatch', [
            'orders' => DemoData::orders(),
            'statuses' => DemoData::statuses(),
            'technicians' => DemoData::technicians(),
            'technicianStatuses' => DemoData::technicianStatuses(),
        ]);
    }

    public function quote(string $code): View
    {
        $order = DemoData::order($code);

        abort_if($order === null, 404);

        return view('prototype.quote', [
            'order' => $order,
            'statuses' => DemoData::statuses(),
            'lines' => DemoData::quoteLines(),
        ]);
    }

    public function finance(): View
    {
        return view('prototype.finance', [
            'receivables' => DemoData::receivables(),
            'cashCollections' => DemoData::cashCollections(),
        ]);
    }

    public function allocations(): View
    {
        return view('prototype.allocations', [
            'profitOrders' => DemoData::profitOrders(),
            'profitSplit' => DemoData::profitSplit(),
        ]);
    }

    public function customers(): View
    {
        return view('prototype.customers', [
            'customers' => DemoData::customers(),
            'statuses' => DemoData::statuses(),
        ]);
    }

    public function schedule(): View
    {
        return view('prototype.schedule', [
            'appointments' => DemoData::schedule(),
            'technicians' => DemoData::technicians(),
            'technicianStatuses' => DemoData::technicianStatuses(),
        ]);
    }

    public function inventory(): View
    {
        return view('prototype.inventory', [
            'materials' => DemoData::materials(),
            'mobileStock' => DemoData::mobileStock(),
            'technicians' => DemoData::technicians(),
        ]);
    }

    public function warranty(): View
    {
        return view('prototype.warranty');
    }

    public function audit(): View
    {
        return view('prototype.audit', ['logs' => DemoData::auditLogs()]);
    }

    public function reports(): View
    {
        return view('prototype.reports', ['weeks' => DemoData::weeklyFinance()]);
    }

    public function mobile(): View
    {
        return view('prototype.mobile');
    }
}
