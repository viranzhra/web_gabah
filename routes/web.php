<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataSensorController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\JenisGabahController;
use App\Http\Controllers\ValidasiDatasetContoller;
use App\Http\Controllers\PrediksiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RoleController;

// Rute publik
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

// Rute yang memerlukan autentikasi
// Route::middleware(['auth'])->group(function () {
    // Rute untuk Operator
    Route::middleware(['role:Operator'])->group(function () {
        // Route::get('/dashboard/operator', function () {
        //     return view('operator.dashboard');
        // })->name('operator.dashboard');
        Route::get('/dashboard/operator', [DashboardController::class, 'index'])->name('operator.dashboard');
        Route::get('/riwayat', function () {
            return view('operator.riwayat');
        })->name('operator.riwayat');
    });

    // Rute untuk Administrator
    Route::middleware(['role:Administrator'])->group(function () {
        Route::get('/dashboard', function () {
            return view('administrator.dashboard');
        })->name('admin.dashboard');

        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::post('/roles/store', [RoleController::class, 'store'])->name('roles.store');
        Route::get('/roles/{id}/edit', [RoleController::class, 'edit']);
        Route::put('/roles/{id}', [RoleController::class, 'update']);
        Route::delete('/roles/{id}', [RoleController::class, 'destroy']);
        Route::get('/datatable/roles', [RoleController::class, 'getRolesData']);
        Route::get('/datatable/users', [RoleController::class, 'getUsersData']);

        Route::get('/data_sensor', [DataSensorController::class, 'index'])->name('data_sensor.index');
        Route::get('/data_device', [DeviceController::class, 'index'])->name('data_device.index');
        Route::get('/data_sensor_button', [DeviceController::class, 'getDeviceNames'])->name('data_sensor.button');

        Route::get('/prediksi', [PrediksiController::class, 'index'])->name('prediksi.index');
        Route::get('/prediksi/create', [PrediksiController::class, 'create'])->name('prediksi.create');

        Route::get('/jenis_gabah', [JenisGabahController::class, 'index'])->name('jenis_gabah.index');
        Route::get('/validasi', [ValidasiDatasetContoller::class, 'index'])->name('validasi.index');
    });

    // Rute logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// });

Route::middleware(['auth'])->group(function () {});


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

Route::get('/nav', function () {
    return view('layout/nav');
});

Route::get('/beranda', function () {
    return view('operator/dashboard');
});


