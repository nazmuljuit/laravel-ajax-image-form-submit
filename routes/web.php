<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SuperAdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontendController;



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

Route::get('/admin', function () {
    return view('welcome');
});

Route::get('get-districts/{id}', [FrontendController::class, 'getDistricts']);
Route::get('get-thanas/{id}', [FrontendController::class, 'getThanas']);
Route::post('submit-form', [FrontendController::class, 'rsave'])->name('aregister.save');

Route::get('/', [FrontendController::class, 'frontpage'])->name('frontpage');


Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');
require __DIR__ . '/auth.php';
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('register/list', [FrontendController::class, 'regList'])->name('aregister.list');


    Route::get('admin/list', [SuperAdminController::class, 'adminList'])->name('admin.list');
    Route::get('admin/create', [SuperAdminController::class, 'adminCreate'])->name('admin.create');
    Route::post('save/admin', [SuperAdminController::class, 'saveAdmin'])->name('admin.save');
    Route::get('admin/edit/{id}', [SuperAdminController::class, 'adminEdit']);

});
