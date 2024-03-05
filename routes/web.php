<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DasborController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ProgrammerController;
use App\Http\Controllers\ProjectManagerController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TesterController;
use App\Http\Controllers\TRFiturController;
use App\Http\Controllers\TRModulController;
use App\Http\Controllers\TRModulViewerController;
use App\Http\Controllers\TRProgrammerController;
use App\Http\Controllers\TRTesterController;
use App\Http\Controllers\TRTiketController;
use App\Http\Controllers\TRTiketHistoriController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Profiler\Profile;

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

Route::get('/', function () {
    return redirect('/dasbor');
    
});

Route::prefix('login')->group(function() {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/process', [LoginController::class, 'process']);
});

Route::middleware('auth')->group(function() {
    // logout
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    // a
    // admin
    Route::prefix('admin')->group(function() {
        Route::get('/', [AdminController::class, 'index'])->name('dm_admin');
        Route::get('/data', [AdminController::class, 'data']);
        Route::get('/{id}', [AdminController::class, 'show'])->where('id', '[0-9]+');
        Route::post('/', [AdminController::class, 'store']);
        Route::delete('/{id}', [AdminController::class, 'delete']);
    });

    // d
    // dasbor
    Route::prefix('dasbor')->group(function() {
        Route::get('/', [DasborController::class, 'index'])->name('dasbor');
        Route::get('/pengingat', [DasborController::class, 'pengingat']);
    });

    // f
    // fitur
    Route::prefix('fitur')->group(function() {
        Route::get('/{tr_modul_id}', [TRFiturController::class, 'index']);
        Route::post('/', [TRFiturController::class, 'store']);
        Route::post('/hasil', [TRFiturController::class, 'hasil']);
        Route::delete('/{id}', [TRFiturController::class, 'delete']);
    });

    // h
    // histori
    Route::prefix('histori')->group(function() {
        Route::get('/{tr_tiket_id}', [TRTiketHistoriController::class, 'index']);
    });

    // m
    // modul
    Route::prefix('modul')->group(function() {
        Route::get('/{tr_tiket_id}', [TRModulController::class, 'data']);
        Route::get('/{id}/show', [TRModulController::class, 'show']);
        Route::post('/', [TRModulController::class, 'store']);
        Route::post('/{id}', [TRModulController::class, 'update']);
        Route::post('/{id}/openAccess', [TRModulController::class, 'openAccess']);
        Route::post('/{id}/endAccess', [TRModulController::class, 'endAccess']);
        Route::post('/{id}/serahkan', [TRModulController::class, 'serahkan']);
        Route::delete('/{id}', [TRModulController::class, 'delete']);
    });

    // modul_viewer
    Route::prefix('modul_viewer')->group(function() {
        Route::get('/{tr_modul_id}', [TRModulViewerController::class, 'index']);
        Route::post('/', [TRModulViewerController::class, 'store']);
    });

    // p
    // profil
    Route::prefix('profil')->group(function() {
        Route::get('/', [ProfilController::class, 'index'])->name('profil');
        Route::get('/{id}', [ProfilController::class, 'show'])->where('id', '[0-9]+');
        Route::get('/edit', [ProfilController::class, 'edit'])->name('prodil.edit');
        Route::post('/{id}', [ProfilController::class, 'update']);
        Route::post('/changePassword', [ProfilController::class, 'changePassword']);
    });

    // programmer
    Route::prefix('programmer')->group(function() {
        Route::get('/', [ProgrammerController::class, 'index'])->name('dm_programmer');
        Route::get('/data', [ProgrammerController::class, 'data']);
        Route::get('/{id}', [ProgrammerController::class, 'show'])->where('id', '[0-9]+');
        Route::post('/', [ProgrammerController::class, 'store']);
        Route::delete('/{id}', [ProgrammerController::class, 'delete']);
    });

    // programmer_tiket
    Route::prefix('programmer_tiket')->group(function() {
        Route::get('/{tr_tiket_id}', [TRProgrammerController::class, 'index']);
        Route::post('/', [TRProgrammerController::class, 'store']);
        Route::delete('/{id}', [TRProgrammerController::class, 'delete']);
    });

    // project_manager
    Route::prefix('project_manager')->group(function() {
        Route::get('/', [ProjectManagerController::class, 'index'])->name('dm_project_manager');
        Route::get('/data', [ProjectManagerController::class, 'data']);
        Route::get('/{id}', [ProjectManagerController::class, 'show'])->where('id', '[0-9]+');
        Route::post('/', [ProjectManagerController::class, 'store']);
        Route::delete('/{id}', [ProjectManagerController::class, 'delete']);
    });

    // t
    // tester
    Route::prefix('tester')->group(function() {
        Route::get('/', [TesterController::class, 'index'])->name('dm_tester');
        Route::get('/data', [TesterController::class, 'data']);
        Route::get('/{id}', [TesterController::class, 'show'])->where('id', '[0-9]+');
        Route::post('/', [TesterController::class, 'store']);
        Route::delete('/{id}', [TesterController::class, 'delete']);
    });

    // tester_tiket
    Route::prefix('tester_tiket')->group(function() {
        Route::get('/{tr_tiket_id}', [TRTesterController::class, 'index']);
        Route::post('/', [TRTesterController::class, 'store']);
        Route::delete('/{id}', [TRTesterController::class, 'delete']);
    });

    // tiket
    Route::prefix('tiket')->group(function() {
        Route::get('/', [TRTiketController::class, 'index'])->name('tiket');
        Route::get('/data', [TRTiketController::class, 'data']);
        Route::get('/{id}', [TRTiketController::class, 'show'])->where('id', '[0-9]+');
        Route::get('/{id}/detail', [TRTiketController::class, 'detail'])->where('id', '[0-9]+');
        Route::get('/{id}/do', [TRTiketController::class, 'do'])->where('id', '[0-9]+');
        Route::get('/{id}/check', [TRTiketController::class, 'check'])->where('id', '[0-9]+');
        Route::post('/', [TRTiketController::class, 'store']);
        Route::post('/url_pengembangan', [TRTiketController::class, 'url_pengembangan']);
        Route::post('/serahkan', [TRTiketController::class, 'serahkan']);
        Route::post('/end', [TRTiketController::class, 'end']);
        Route::delete('/{id}', [TRTiketController::class, 'delete']);
    });

    Route::get('/test', [TestController::class, 'index']);
    
});
