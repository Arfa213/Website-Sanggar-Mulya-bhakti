<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{HomeController, ProfileController as FrontProfileController,
    EventController as FrontEventController, DigitalArchiveController};
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\{DashboardController, ProfileController,
    EventController, TarianController, AnggotaController, GaleriController};

Route::get('/',                [HomeController::class,          'index'])->name('home');
Route::get('/profile',         [FrontProfileController::class,  'index'])->name('profile');
Route::get('/event',           [FrontEventController::class,    'index'])->name('event');
Route::get('/digital-archive', [DigitalArchiveController::class,'index'])->name('digital-archive');

Route::middleware('guest')->group(function () {
    Route::get('/masuk',   [AuthController::class, 'showLogin'])->name('login');
    Route::post('/masuk',  [AuthController::class, 'login'])->name('login.post');
    Route::get('/daftar',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/daftar', [AuthController::class, 'register'])->name('register.post');
});
Route::get('/lupa-password', fn() => back())->name('password.request');
Route::post('/keluar', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::middleware('auth')->get('/dashboard', fn() => view('pages.dashboard'))->name('dashboard');

Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::put('/profil',                   [ProfileController::class, 'updateProfil'])->name('profil.update');
    Route::get('/profil',                   [ProfileController::class, 'index'])->name('profil.index');
    Route::post('/pelatih',                 [ProfileController::class, 'storePelatih'])->name('pelatih.store');
    Route::put('/pelatih/{pelatih}',        [ProfileController::class, 'updatePelatih'])->name('pelatih.update');
    Route::delete('/pelatih/{pelatih}',     [ProfileController::class, 'destroyPelatih'])->name('pelatih.destroy');
    Route::post('/pengelola',               [ProfileController::class, 'storePengelola'])->name('pengelola.store');
    Route::put('/pengelola/{pengelola}',    [ProfileController::class, 'updatePengelola'])->name('pengelola.update');
    Route::delete('/pengelola/{pengelola}', [ProfileController::class, 'destroyPengelola'])->name('pengelola.destroy');
    Route::post('/jadwal',                  [ProfileController::class, 'storeJadwal'])->name('jadwal.store');
    Route::put('/jadwal/{jadwal}',          [ProfileController::class, 'updateJadwal'])->name('jadwal.update');
    Route::delete('/jadwal/{jadwal}',       [ProfileController::class, 'destroyJadwal'])->name('jadwal.destroy');
    Route::resource('event',   EventController::class);
    Route::resource('tarian',  TarianController::class);
    Route::get('/anggota',                  [AnggotaController::class, 'index'])->name('anggota.index');
    Route::get('/anggota/create',           [AnggotaController::class, 'create'])->name('anggota.create');
    Route::post('/anggota',                 [AnggotaController::class, 'store'])->name('anggota.store');
    Route::get('/anggota/{anggota}/edit',   [AnggotaController::class, 'edit'])->name('anggota.edit');
    Route::put('/anggota/{anggota}',        [AnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('/anggota/{anggota}',     [AnggotaController::class, 'destroy'])->name('anggota.destroy');
    Route::patch('/anggota/{anggota}/toggle',[AnggotaController::class,'toggleStatus'])->name('anggota.toggle');
    Route::get('/galeri',                   [GaleriController::class, 'index'])->name('galeri.index');
    Route::post('/galeri',                  [GaleriController::class, 'store'])->name('galeri.store');
    Route::put('/galeri/{galeri}',          [GaleriController::class, 'update'])->name('galeri.update');
    Route::delete('/galeri/{galeri}',       [GaleriController::class, 'destroy'])->name('galeri.destroy');
    Route::post('/galeri/reorder',          [GaleriController::class, 'reorder'])->name('galeri.reorder');
});