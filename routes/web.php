<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataSensorController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\JenisGabahController;
use App\Http\Controllers\ValidasiPengeringanContoller;
use App\Http\Controllers\PrediksiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RoleController;

Route::get('/', function () {
    return view('landingpage');
});
Route::get('/beli', function () {
    return view('beli_sekarang');
});
Route::get('/pesanan', function () {
    return view('pesanan.index');
});
Route::get('/informasi_umum', function () {
    return view('informasi_umum');
});
Route::get('/warehouse', function () {
    return view('administrator.data_master.warehouse');
});
Route::get('/bed_dryer', function () {
    return view('administrator.data_master.bed_dryer');
});

// Rute publik
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login/submit', [LoginController::class, 'login'])->name('login.submit');

// Rute yang memerlukan autentikasi
// Route::middleware(['auth'])->group(function () {
// Rute untuk Operator
// Route::middleware(['role:Operator'])->group(function () {
//     // Route::get('/dashboard/operator', function () {
//     //     return view('operator.dashboard');
//     // })->name('operator.dashboard');
//     Route::get('/dashboard/operator', [DashboardController::class, 'index'])->name('operator.dashboard');
//     Route::get('/riwayat', function () {
//         return view('operator.riwayat');
//     })->name('operator.riwayat');
// });

// Rute untuk Administrator
Route::middleware(['auth'])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('administrator.dashboard');
    // })->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/roles', [RoleController::class, 'getRoles']);
    Route::post('/roles', [RoleController::class, 'storeRole']);
    Route::get('/roles/{id}', [RoleController::class, 'showRole']);
    Route::put('/roles/{id}', [RoleController::class, 'updateRole']);
    Route::delete('/roles/{id}', [RoleController::class, 'destroyRole']);
    Route::get('/users', [RoleController::class, 'getUsers']);
    Route::post('/users', [RoleController::class, 'storeUser']);
    Route::get('/users/{id}', [RoleController::class, 'showUser']);
    Route::put('/users/{id}', [RoleController::class, 'updateUser']);
    Route::delete('/users/{id}', [RoleController::class, 'destroyUser']);
    Route::get('/role_manage', [RoleController::class, 'index']);
    Route::get('/permissions', [RoleController::class, 'getPermissions']);
    Route::get('/users/{id}', [RoleController::class, 'showUser']);

    Route::get('/data_sensor', [DataSensorController::class, 'index'])->name('data_sensor.index');
    Route::get('/data_device', [DeviceController::class, 'index'])->name('data_device.index');
    Route::get('/data_sensor_button', [DeviceController::class, 'getDeviceNames'])->name('data_sensor.button');

    Route::get('/prediksi', [PrediksiController::class, 'index'])->name('prediksi.index');
    Route::get('/prediksi/create', [PrediksiController::class, 'create'])->name('prediksi.create');

    Route::get('/jenis_gabah', [JenisGabahController::class, 'index'])->name('jenis_gabah.index');
    Route::get('/validasi', [ValidasiPengeringanContoller::class, 'index'])->name('validasi.index');

    Route::get('/profile/edit', function () {
        return view('profile.edit');
    });
});

// Rute logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// });

// Route::middleware(['auth'])->group(function () {});


Route::get('/logout', function () {
    session()->flush();
    return redirect()->route('login')->with('success', 'Berhasil logout.');
})->name('logout');

// === Dibawah Controller lama ===

// Route::get('/', function () {
//     return view('login');
// });

// Route::get('/dashboard', function () {
//     return view('administrator/dashboard');
// });

Route::get('/sample', function () {
    return view('sample-page');
});
// Route::get('/riwayat', function () {
//     return view('administrator.riwayat.index');
// });

use App\Http\Controllers\RiwayatController;

// Route::get('/riwayat/data', [RiwayatController::class, 'data'])->name('riwayat.data');

Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
Route::get('/riwayat/detail/{process_id}', [RiwayatController::class, 'detail'])->name('riwayat.detail');
Route::get('/sensor-detail/{process_id}', [RiwayatController::class, 'detail'])->name('sensor.detail');

// Route::get('/riwayat', fn() => view('administrator.riwayat.index'))->name('riwayat.index');

Route::get('/grafik', function () {
    return view('administrator.coba_grafik');
});

Route::get('/contoh_dashboard', function () {
    return view('contoh_dashboard');
});

Route::get('/nav', function () {
    return view('layout/nav');
});

Route::get('/beranda', function () {
    return view('operator/dashboard');
});
