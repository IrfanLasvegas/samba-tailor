<?php

use App\Http\Controllers\BagianController;
use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\GrafikController;
use App\Http\Controllers\HargaJasaController;
use App\Http\Controllers\JasaController;
use App\Http\Controllers\ManageUserController;
use App\Http\Controllers\pembayaranController;
use App\Http\Controllers\PengerjaanController;
use App\Http\Controllers\PenghasilanController;
use App\Http\Controllers\PersentaseBagianController;
use App\Http\Controllers\RoleController;
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



// Route::get('/', function () {
//     return view('ViewAdmin.va_pembayaran.va_pembayaran_index');
// })->middleware(['auth']);

// home
Route::get('/', [pembayaranController::class, 'index'])->middleware(['auth', 'is_super_admin_or_admin']); 

// role
Route::get('/role/all', [RoleController::class, 'allData'])->middleware(['auth', 'is_super_admin']); 

// user
Route::get('/manage-user', [ManageUserController::class, 'index'])->middleware(['auth', 'is_super_admin']); 
Route::get('/manage-user/all', [ManageUserController::class, 'allData'])->middleware(['auth', 'is_super_admin_or_admin']);  
Route::get('/manage-user/all2', [ManageUserController::class, 'allAjaxData'])->middleware(['auth', 'is_super_admin']); 
Route::post('/manage-user/store', [ManageUserController::class, 'storeData'])->middleware(['auth', 'is_super_admin']);  
Route::get('/manage-user/edit/{id}', [ManageUserController::class, 'editData'])->middleware(['auth', 'is_super_admin']);  
Route::post('/manage-user/update/{id}', [ManageUserController::class, 'updateData'])->middleware(['auth', 'is_super_admin']); 
Route::delete('/manage-user/delete/{id}', [ManageUserController::class, 'deleteData'])->middleware(['auth', 'is_super_admin']); 

// bagian
Route::get('/bagian', [BagianController::class, 'index'])->middleware(['auth', 'is_super_admin']);  
Route::get('/bagian/all', [BagianController::class, 'allData'])->middleware(['auth', 'is_super_admin']);  
Route::post('/bagian/store', [BagianController::class, 'storeData'])->middleware(['auth', 'is_super_admin']);  
Route::get('/bagian/edit/{id}', [BagianController::class, 'editData'])->middleware(['auth', 'is_super_admin']);  
Route::post('/bagian/update/{id}', [BagianController::class, 'updateData'])->middleware(['auth', 'is_super_admin']); 
Route::delete('/bagian/delete/{id}', [BagianController::class, 'deleteData'])->middleware(['auth', 'is_super_admin']); 

// persentase
Route::get('/persentase/allActive', [PersentaseBagianController::class, 'allActiveStatusData'])->middleware(['auth', 'is_super_admin_or_admin']);  
Route::get('/persentase/all', [PersentaseBagianController::class, 'allData'])->middleware(['auth', 'is_super_admin']);  
Route::post('/persentase/store', [PersentaseBagianController::class, 'storeData'])->middleware(['auth'], 'is_super_admin');  
Route::get('/persentase/edit/{id}', [PersentaseBagianController::class, 'editData'])->middleware(['auth'], 'is_super_admin');  
Route::post('/persentase/update/{id}', [PersentaseBagianController::class, 'updateData'])->middleware(['auth', 'is_super_admin']); 
Route::delete('/persentase/delete/{id}', [PersentaseBagianController::class, 'deleteData'])->middleware(['auth', 'is_super_admin']); 
Route::get('/persentase/sumActive', [PersentaseBagianController::class, 'sumActiveStatusData'])->middleware(['auth', 'is_super_admin']);  

// jasa
Route::get('/jasa', [JasaController::class, 'index'])->middleware(['auth', 'is_super_admin']);  
Route::get('/jasa/all', [JasaController::class, 'allData'])->middleware(['auth', 'is_super_admin']);  
Route::post('/jasa/store', [JasaController::class, 'storeData'])->middleware(['auth', 'is_super_admin']);  
Route::get('/jasa/edit/{id}', [JasaController::class, 'editData'])->middleware(['auth', 'is_super_admin']);  
Route::post('/jasa/update/{id}', [JasaController::class, 'updateData'])->middleware(['auth', 'is_super_admin']); 
Route::delete('/jasa/delete/{id}', [JasaController::class, 'deleteData'])->middleware(['auth', 'is_super_admin']); 

// harga
Route::get('/harga/allActive', [HargaJasaController::class, 'allActiveData'])->middleware(['auth', 'is_super_admin_or_admin']);  
Route::get('/harga/all', [HargaJasaController::class, 'allData'])->middleware(['auth', 'is_super_admin']);  
Route::post('/harga/store', [HargaJasaController::class, 'storeData'])->middleware(['auth', 'is_super_admin']);  
Route::get('/harga/edit/{id}', [HargaJasaController::class, 'editData'])->middleware(['auth', 'is_super_admin']);  
Route::post('/harga/update/{id}', [HargaJasaController::class, 'updateData'])->middleware(['auth', 'is_super_admin']); 
Route::delete('/harga/delete/{id}', [HargaJasaController::class, 'deleteData'])->middleware(['auth', 'is_super_admin']); 

// pengerjaan
Route::get('/pengerjaan', [PengerjaanController::class, 'index'])->middleware(['auth','is_super_admin_or_admin']);  
Route::get('/pengerjaan/all', [PengerjaanController::class, 'allAjaxData'])->middleware(['auth', 'is_super_admin_or_admin']);  
Route::post('/pengerjaan/store', [PengerjaanController::class, 'storeData'])->middleware(['auth', 'is_super_admin_or_admin']);  
Route::get('/pengerjaan/edit/{id}', [PengerjaanController::class, 'editData'])->middleware(['auth', 'is_super_admin_or_admin']);  
Route::post('/pengerjaan/update/{id}', [PengerjaanController::class, 'updateData'])->middleware(['auth', 'is_super_admin_or_admin']); 
Route::delete('/pengerjaan/delete/{id}', [PengerjaanController::class, 'deleteData'])->middleware(['auth', 'is_super_admin_or_admin']); 
Route::get('/pengerjaan/check-payment/{id}', [PengerjaanController::class, 'checkPaymentjeData'])->middleware(['auth','is_super_admin']);  

// penghasilan
Route::get('/penghasilan', [PenghasilanController::class, 'index'])->middleware(['auth', 'is_super_admin']);  
Route::post('/penghasilan/all', [PenghasilanController::class, 'allAjaxData'])->middleware(['auth', 'is_super_admin']);  
// Route::post('/penghasilan/store', [PenghasilanController::class, 'storeData']); 
Route::get('/penghasilan/edit/{id}', [PenghasilanController::class, 'editData'])->middleware(['auth', 'is_super_admin']);  
Route::post('/penghasilan/update/{id}', [PenghasilanController::class, 'updateData'])->middleware(['auth', 'is_super_admin']); 
Route::delete('/penghasilan/delete/{id}', [PenghasilanController::class, 'deleteData'])->middleware(['auth', 'is_super_admin']); 
Route::post('/penghasilan/checkTotal', [PenghasilanController::class, 'checkTotalData'])->middleware(['auth', 'is_super_admin']);  

// grafik 
Route::get('/grafik', [GrafikController::class, 'index'])->middleware(['auth', 'is_super_admin']);  
Route::post('/grafik/hari', [GrafikController::class, 'harianData'])->middleware(['auth', 'is_super_admin']);  
Route::post('/grafik/minggu', [GrafikController::class, 'mingguanData'])->middleware(['auth', 'is_super_admin']);  
Route::post('/grafik/bulan', [GrafikController::class, 'bulananData'])->middleware(['auth', 'is_super_admin']);  
Route::post('/grafik/tahun', [GrafikController::class, 'tahunanData'])->middleware(['auth', 'is_super_admin']);  
Route::post('/grafik/grup-tahun', [GrafikController::class, 'grupTahunData'])->middleware(['auth', 'is_super_admin']);  

//pembayaan
// Route::get('/pembayaran', [pembayaranController::class, 'index']); 
Route::get('/pembayaran/all', [pembayaranController::class, 'allAjaxData'])->middleware(['auth', 'is_super_admin_or_admin']); 
Route::post('/pembayaran/store', [pembayaranController::class, 'storeData'])->middleware(['auth', 'is_super_admin_or_admin']);  
Route::post('/pembayaran/cancel', [pembayaranController::class, 'cancelData'])->middleware(['auth', 'is_super_admin_or_admin']);  
Route::post('/pembayaran/print', [pembayaranController::class, 'printData'])->middleware(['auth', 'is_super_admin_or_admin']); 
Route::get('/pembayaran/edit/{id}', [pembayaranController::class, 'editData'])->middleware(['auth', 'is_super_admin_or_admin']); 
Route::get('/pembayaran/print-one-history/{id}', [pembayaranController::class, 'printOneHistoryData'])->middleware(['auth', 'is_super_admin_or_admin']);  
Route::delete('/pembayaran/delete/{id}', [pembayaranController::class, 'deleteData'])->middleware(['auth', 'is_super_admin_or_admin']);  

// barcode
Route::get('/barcode', [BarcodeController::class, 'index'])->middleware(['auth', 'is_super_admin']);  


// Route::get('/barcode-download', [BarcodeController::class, 'downloadFileExportPdf']); 


// Route::get('/pdf-barcode', [BarcodeController::class, 'exportBarcodePDF1']); 
// Route::get('/pdf-barcode2', [BarcodeController::class, 'exportBarcodePDF2']); 
// Route::get('/pdf-batch/{batch_id}', [BarcodeController::class, 'pdfBatch']); 
// Route::get('/generate-exel', [BarcodeController::class, 'generateExel']); 

// Route::get('/pdf-barcode3', [BarcodeController::class, 'exportBarcodePDF3']); 













Route::get('/test', [PengerjaanController::class, 'test']);


