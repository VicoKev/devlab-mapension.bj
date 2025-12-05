<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BulkPaymentController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/mojaloop', [BulkPaymentController::class, 'index'])->name('bulk-payment.index');
// Route::post('/upload', [BulkPaymentController::class, 'upload'])->name('bulk-payment.upload');
// Route::get('/batch/{id}', [BulkPaymentController::class, 'show'])->name('bulk-payment.show');
// Route::post('/batch/{id}/process', [BulkPaymentController::class, 'process'])->name('bulk-payment.process');
// Route::get('/batch/{id}/download', [BulkPaymentController::class, 'downloadReport'])->name('bulk-payment.download');
// Route::get('/batch/{id}/refresh', [BulkPaymentController::class, 'refreshStatus'])->name('bulk-payment.refresh');

// Route::get('/health', function () {
//     return response()->json(['status' => 'OK'], 200);
// });


Route::get('/bulk-payments', [BulkPaymentController::class, 'index'])->name('bulk-payment.index');
Route::post('/bulk-payments/upload', [BulkPaymentController::class, 'upload'])->name('bulk-payment.upload');
Route::post('/bulk-payments/import', [BulkPaymentController::class, 'import'])->name('bulk-payment.import'); // confirme l'import des valides
Route::get('/bulk-payments/{id}', [BulkPaymentController::class, 'show'])->name('bulk-payment.show');
Route::post('/bulk-payments/{id}/process', [BulkPaymentController::class, 'process'])->name('bulk-payment.process');
Route::get('/bulk-payments/{id}/download', [BulkPaymentController::class, 'downloadReport'])->name('bulk-payment.download');
Route::get('/bulk-payments/{id}/refresh-status', [BulkPaymentController::class, 'refreshStatus'])->name('bulk-payment.refresh');
