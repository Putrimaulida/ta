<?php

use App\Http\Controllers\CitraSatelitController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\DashboardStakeholder;
use App\Http\Controllers\DataLapangController;
use App\Http\Controllers\HasilAnalisisController;
use App\Http\Controllers\HasilAnalisisStakeholderController;
use App\Http\Controllers\JenisMangroveController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\StakeholderController;
use App\Http\Controllers\PantaiController;
use App\Http\Controllers\PantaiStakeholderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/',[
    LandingPageController::class, 'indexBeranda'
]);
Route::prefix('/')->group(function(){
    Route::get('/countRecommendedBeranda', [LandingPageController::class, 'countRecommendedBeranda']);
    Route::post('/analisisdatapantai', [LandingPageController::class, 'countRecommendedBeranda'])->name('countRecommendedBeranda');
});

Auth::routes();
Route::prefix('dashboard_admin')->middleware(['auth', 'check.role:admin'])->group(function () {
    Route::get('/', [DashboardAdminController::class, 'index'])->name('admin.dashboard');

    // Stakeholder Management
    Route::get('/stakeholder_management', [StakeholderController::class, 'index'])->name('admin.stakeholder');
    Route::get('/stakeholder_management/create', [StakeholderController::class, 'create']);
    Route::post('/stakeholder_management/create/store', [StakeholderController::class, 'store']);
    Route::get('/stakeholder_management/edit/{id}', [StakeholderController::class, 'edit']);
    Route::put('/stakeholder_management/update/{id}', [StakeholderController::class, 'update']);
    Route::get('/stakeholder_management/view', [StakeholderController::class, 'json'])->name('admin.data.stakeholder');
    Route::get('/stakeholder_management', [StakeholderController::class, 'index'])->name('admin.stakeholder');
    Route::delete('/stakeholder_management/destroy/{id}', [StakeholderController::class, 'destroy'])->name('admin.stakeholder.destroy');

    // Jenis Mangrove
    Route::get('/jenis_mangrove', [JenisMangroveController::class, 'index'])->name('admin.mangrove');
    Route::get('/jenis_mangrove/create', [JenisMangroveController::class, 'create']);
    Route::post('/jenis_mangrove/create/store', [JenisMangroveController::class, 'store']);
    Route::get('/jenis_mangrove/edit/{id}', [JenisMangroveController::class, 'edit']);
    Route::put('/jenis_mangrove/update/{id}', [JenisMangroveController::class, 'update']);
    Route::get('/jenis_mangrove/view', [JenisMangroveController::class, 'json'])->name('admin.data.mangrove');
    Route::get('/jenis_mangrove', [JenisMangroveController::class, 'index'])->name('admin.mangrove');
    Route::delete('/jenis_mangrove/destroy/{id}', [JenisMangroveController::class, 'destroy'])->name('admin.mangrove.destroy');

    // Pantai
    Route::get('/pantai', [PantaiController::class, 'index'])->name('admin.pantai');
    Route::get('/pantai/create', [PantaiController::class, 'create']);
    Route::post('/pantai/create/store', [PantaiController::class, 'store']);
    Route::get('/pantai/edit/{id}', [PantaiController::class, 'edit']);
    Route::put('/pantai/update/{id}', [PantaiController::class, 'update']);
    Route::get('/pantai/view/{id}', [PantaiController::class, 'show']);
    Route::get('/pantai/view', [PantaiController::class, 'json'])->name('admin.data.pantai');
    Route::delete('/pantai/destroy/{id}', [PantaiController::class, 'destroy'])->name('admin.pantai.destroy');
    Route::get('/pantai/verifikasilaporan/{id}', [PantaiController::class, 'verifikasi']);
    Route::put('/pantai/verifikasikomen/{id}', [PantaiController::class, 'verifikasiLaporan']);

    // Citra
    Route::get('/citra', [CitraSatelitController::class, 'index'])->name('admin.citra');
    Route::get('/citra/create', [CitraSatelitController::class, 'create']);
    Route::post('/citra/create/store', [CitraSatelitController::class, 'store']);
    Route::get('/citra/edit/{id}', [CitraSatelitController::class, 'edit']);
    Route::put('/citra/update/{id}', [CitraSatelitController::class, 'update']);
    Route::get('/citra/view', [CitraSatelitController::class, 'json'])->name('admin.data.citra');
    Route::get('/citra/view/{id}', [CitraSatelitController::class, 'json1'])->name('admin.citra.detail.ajax');
    Route::get('/citra/{id}', [CitraSatelitController::class, 'citraPantai'])->name('admin.citra.detail');
    Route::delete('/citra/destroy/{id}', [CitraSatelitController::class, 'destroy'])->name('admin.citra.destroy');

    // Lapang
    Route::get('/lapang', [DataLapangController::class, 'index'])->name('admin.lapang');
    Route::get('/lapang/create', [DataLapangController::class, 'create']);
    Route::post('/lapang/create/store', [DataLapangController::class, 'store']);
    Route::get('/lapang/edit/{id}', [DataLapangController::class, 'edit']);
    Route::put('/lapang/update/{id}', [DataLapangController::class, 'update']);
    Route::get('/lapang/view', [DataLapangController::class, 'json'])->name('admin.data.lapang');
    Route::delete('/lapang/destroy/{id}', [DataLapangController::class, 'destroy'])->name('admin.lapang.destroy');

    // Hasil Analisis
    Route::get('/analisisdata', [HasilAnalisisController::class, 'index'])->name('admin.analisis');
    Route::post('/analisisdata/count', [HasilAnalisisController::class, 'countRecommended'])->name('countRecommended');

    // Profile
    Route::get('/profile', [UserController::class, 'edit'])->name('admin.profile.edit');
    Route::put('/profile/{id}', [UserController::class, 'update'])->name('admin.profile.update');
});

Route::prefix('/dashboard_stakeholder')->middleware(['auth', 'check.role:stakeholder'])->group(function () {
    Route::get('/', [DashboardStakeholder::class, 'index'])->name('stakeholder.dashboard');
    Route::get('/pantai', [PantaiStakeholderController::class, 'index'])->name('stakeholder.pantai');
    Route::get('/pantai/view', [PantaiStakeholderController::class, 'json'])->name('stakeholder.data.pantai');
    Route::get('/pantai/edit/{id}', [PantaiStakeholderController::class, 'edit']);
    Route::put('/pantai/update/{id}', [PantaiStakeholderController::class, 'update']);
    Route::get('/pantai/view/{id}', [PantaiStakeholderController::class, 'show']);

    // Hasil Analisis
    Route::get('/analisisdata', [HasilAnalisisStakeholderController::class, 'index'])->name('stakeholder.analisis');
    Route::post('/analisisdata/count', [HasilAnalisisStakeholderController::class, 'countRecommendedStakeholder'])->name('countRecommendedStakeholder');
    Route::post('/analisisdata/count-all', [HasilAnalisisStakeholderController::class, 'countAllRecommendedStakeholder'])->name('countAllRecommendedStakeholder');
});
