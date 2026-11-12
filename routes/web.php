<?php

use App\Http\Controllers\PrototypeController;
use Illuminate\Support\Facades\Route;

Route::controller(PrototypeController::class)->group(function () {
    Route::get('/', 'login')->name('login');
    Route::get('/vai-tro/{role}', 'switchRole')->name('role.switch');

    Route::get('/control-tower', 'dashboard')->name('dashboard');
    Route::get('/don-hang', 'orders')->name('orders.index');
    Route::get('/don-hang/{code}', 'order')->name('orders.show');

    Route::get('/sale', 'saleHome')->name('sale.home');
    Route::get('/sale/tao-lead', 'createLead')->name('leads.create');
    Route::get('/khach-hang', 'customers')->name('customers.index');

    Route::get('/dieu-phoi', 'dispatch')->name('dispatch');
    Route::get('/lich-trien-khai', 'schedule')->name('schedule');
    Route::get('/bao-gia/{code}', 'quote')->name('quotes.show');
    Route::get('/tai-chinh', 'finance')->name('finance');

    Route::get('/chi-phi-loi-nhuan', 'allocations')->name('allocations');
    Route::get('/kho', 'inventory')->name('inventory');
    Route::get('/bao-hanh', 'warranty')->name('warranty');
    Route::get('/audit-log', 'audit')->name('audit');
    Route::get('/bao-cao', 'reports')->name('reports');

    Route::get('/app-ky-thuat', 'mobile')->name('mobile');
});
