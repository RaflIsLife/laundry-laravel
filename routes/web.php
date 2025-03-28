<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'UserController@home')->name('home');

Route::get('/register', 'UserController@register')->name('register');
Route::get('/login', 'UserController@login')->name('login');
Route::post("/postLogin", 'UserController@postLogin')->name('postLogin');
Route::post("/postRegister", 'UserController@postRegister')->name('postRegister');

//midtrans
Route::get("/payToken/{transaksi}", 'UserController@snapToken')->name('payMidtransToken');
Route::post('/midtrans/notification', 'MidtransNotificationController@notificationHandler')->name('midtrans.notification');
Route::get('/assign-pending-orders-redirect', function () {
    $userController = new \App\Http\Controllers\UserController();
    $userController->assignPendingOrders();
    return redirect()->route('user')->with('status', 'Pembayaran berhasil!');
})->name('assign.pending.orders.redirect');

Route::middleware('auth')->group(function () {
    Route::middleware('check:admin')->group(function () {
        Route::get('/admin', 'AdminController@admin')->name('admin.home');
        Route::get('/admin/akun', 'AdminController@akun')->name('admin.akun');
        Route::delete('/admin/akun/delete/{id}', 'AdminController@akunDestroy')->name('admin.akun.delete');
        Route::get('/admin/akun/update/{id}', 'AdminController@akunUpdate')->name('admin.akun.update');
        Route::put('/admin/akun/postUpdate/{id}', 'AdminController@postAkunUpdate')->name('postAkunUpdate');
        Route::get('/admin/create', 'AdminController@create')->name('admin.akun.create');
        Route::get('/admin/layanan', 'AdminController@layanan')->name('admin.layanan');
        Route::get('/admin/layananCreate', 'AdminController@layananCreate')->name('admin.layanan.create');
        Route::post('/admin/postLayanan', 'AdminController@postLayanan')->name('admin.layanan.post');
        Route::get('/admin/layanan/update/{id}', 'AdminController@layananUpdate')->name('admin.layanan.update');
        Route::put('/admin/layanan/postUpdate/{id}', 'AdminController@postLayananUpdate')->name('postLayananUpdate');
        Route::post("/postCreate", 'AdminController@postCreate')->name('postCreate');
        Route::get('/admin/history', 'AdminController@historyAdmin')->name('admin.history');
        Route::get('/admin/detailPesanan/{transaksi}', 'AdminController@detailPesanan')->name('admin.detailPesanan');
        Route::get('/admin/detailHistory/{transaksi}', 'AdminController@detailHistory')->name('admin.detailHistory');
    });

    Route::middleware('check:kurir')->group(function () {
        Route::get('/kurir', 'KurirController@home')->name('kurir');
        Route::post('/kurir/mark-paid/{transaksi}', 'KurirController@markPaid')->name('kurir.mark-paid');
        Route::post('/kurir/complete-order/{transaksi}', 'KurirController@completeOrder')->name('kurir.complete-order');
        Route::get('/kurir/detail/{transaksi}', 'KurirController@detail')->name('kurir.detail');
    });
    Route::middleware('check:kasir')->group(function () {
        Route::get('/kasir', 'KasirController@kasir')->name('kasir');
        Route::post('/postKasir', 'KasirController@postKasir')->name('postKasir');
        Route::get('/kasir/transaksi', 'KasirController@transaksi')->name('kasir.transaksi');
        Route::post('/kasir/transaksi/{transaksi}/status', 'KasirController@updateStatus')->name('kasir.transaksi.update-status');
        Route::get('/kasir/history', 'KasirController@history')->name('kasir.history');
        Route::get('/kasir/detailPesanan/{transaksi}', 'KasirController@detailPesanan')->name('kasir.detailPesanan');
        Route::get('/autocomplete', 'KasirController@autocomplete')->name('autocomplete');
    });

    Route::middleware('check:owner')->group(function () {
        Route::get('/owner', 'OwnerController@home')->name('owner');
    });

    Route::middleware('check:customer')->group(function () {
        Route::get('/user', 'UserController@user')->name('user');
        Route::get('/user/detailPesanan/{transaksi}', 'UserController@detailPesanan')->name('detailPesanan');
        Route::get('/user/detailRiwayat/{transaksi}', 'UserController@detailRiwayat')->name('detailRiwayat');
        Route::get('/user/new', 'UserController@pesananBaru')->name('pesananBaru');
        Route::post('/postPesanan', 'UserController@postPesanan')->name('pesananBaru.post');
        Route::get('/user/history', 'UserController@history')->name('history');
        Route::get('/user/profile', 'UserController@profile')->name('profile');
        Route::post('/user/postProfile', 'UserController@profileUpdate')->name('profile.update');
    });

    Route::post('/logout', 'UserController@logout')->name('logout');
});
