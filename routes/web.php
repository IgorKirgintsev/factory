<?php

use Illuminate\Support\Facades\Route;
use App\Providers\Filament\AdminPanelProvider;
use App\Http\Controllers\InvController;
use App\Http\Controllers\ReeorderController;
use App\Http\Controllers\ReepayController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ReportController;
use App\Filament\Pages\ManMproduct;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//Route::get('/', AdminPanelProvider::class);


//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/{order}/pdf/download',[InvController::class,'download'])->name('order.pdf.download');
Route::get('/pdf/order',[ReeorderController::class,'download'])->name('reeord.pdf.download');
Route::get('/clients/pdf', [PdfController::class,'getPdf'])->name('pdf');
Route::get('/report/pdf', [ReportController::class,'ReportPdf'])->name('reportpdf');
Route::get('/pdf/pay',[ReepayController::class,'download'])->name('reepay.pdf.download');
//Route::get('/manage',ManMproduct::class)->name('manage');
